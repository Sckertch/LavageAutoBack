<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProduitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // GET /api/prestations → retourne toutes les prestations
    public function index(): JsonResponse
    {
        return response()->json(Produit::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       $validated = $request->validate([
           'nom' => ['required', 'string', 'max:255'],
           'caracteristique' => ['required', 'string'],
           'prix' => ['required', 'numeric','min:0'],
           'image' => ['nullable', 'string', 'max:255'],
       ]);

       $produit = Produit::create($validated);

       return response()->json($produit,201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Produit $produit): JsonResponse
    {
        return response()->json($produit);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Produit $produit)
    {
        $validated = $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'caracteristique' => ['required', 'string'],
            'prix' => ['required', 'numeric','min:0'],
            'image' => ['nullable', 'string', 'max:255'],
        ]);

        $produit->update($validated);

        return response()->json($produit,201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Produit $produit)
    {
        $produit->delete();
        return response()->json([
            'message' => 'Produit supprimée avec succès',
        ]);
    }
}
