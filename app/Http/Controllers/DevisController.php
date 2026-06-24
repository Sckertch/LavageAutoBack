<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDevisRequest;
use App\Models\Devis;
use App\Models\Prestation;
use App\Models\Produit;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class DevisController extends Controller
{
    /**
     * Créer un devis, générer le PDF et le sauvegarder.
     */
    public function store(StoreDevisRequest $request): JsonResponse
    {
        $lignesData = [];
        $totalHt    = 0;

        // ── Résolution des lignes depuis la BDD (on ignore les prix du front) ──
        foreach ($request->lignes as $ligne) {
            if ($ligne['type'] === 'prestation') {
                $item = Prestation::findOrFail($ligne['id']);
            } else {
                $item = Produit::findOrFail($ligne['id']);
            }

            $quantite   = $ligne['quantite'];
            $sousTotal  = round($item->prix * $quantite, 2);
            $totalHt   += $sousTotal;

            $lignesData[] = [
                'type'         => $ligne['type'],
                'reference_id' => $item->id,
                'nom'          => $item->nom,
                'prix_unitaire'=> $item->prix,
                'quantite'     => $quantite,
                'sous_total'   => $sousTotal,
            ];
        }

        // ── Création du devis en BDD ──
        $devis = Devis::create([
            'client_nom'       => $request->client_nom,
            'client_email'     => $request->client_email,
            'client_telephone' => $request->client_telephone,
            'total_ht'         => round($totalHt, 2),
            'statut'           => 'en_attente',
            'fichier_path'     => null,
        ]);

        // ── Création des lignes ──
        $devis->lignes()->createMany($lignesData);

        // ── Génération du PDF ──
        $devisAvecLignes = $devis->load('lignes');

        $pdf = Pdf::loadView('pdf.devis', [
            'devis' => $devisAvecLignes,
        ])->setPaper('a4', 'portrait');

        // Sauvegarde dans storage/app/private/devis/
        $fileName   = 'devis-' . $devis->id . '-' . now()->format('Ymd') . '.pdf';
        $filePath   = 'devis/' . $fileName;

        Storage::put($filePath, $pdf->output());

        // ── Mise à jour du chemin en BDD ──
        $devis->update(['fichier_path' => $filePath]);

        return response()->json([
            'message'   => 'Devis créé avec succès',
            'devis_id'  => $devis->id,
            'fichier'   => $filePath,
        ], 201);
    }

    /**
     * Lister tous les devis (back office).
     */
    public function index(): JsonResponse
    {
        $devis = Devis::with('lignes')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($devis);
    }

    /**
     * Voir un devis spécifique.
     */
    public function show(Devis $devis): JsonResponse
    {
        return response()->json($devis->load('lignes'));
    }

    /**
     * Télécharger le PDF d'un devis.
     */
    public function download(Devis $devis): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        abort_if(!$devis->fichier_path, 404, 'PDF non disponible');
        abort_if(!Storage::exists($devis->fichier_path), 404, 'Fichier introuvable');

        return Storage::download(
            $devis->fichier_path,
            'devis-' . $devis->id . '.pdf'
        );
    }

    /**
     * Mettre à jour le statut d'un devis (accepté, refusé).
     */
    public function updateStatut(Devis $devis): JsonResponse
    {
        $validated = request()->validate([
            'statut' => ['required', 'in:en_attente,accepte,refuse'],
        ]);

        $devis->update($validated);

        return response()->json($devis);
    }
}
