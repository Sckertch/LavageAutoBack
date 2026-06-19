<?php

namespace App\Http\Controllers;

use App\Models\Prestation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PrestationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // GET /api/prestations → retourne toutes les prestations
    public function index() : JsonResponse
    {
        return response()->json(Prestation::all()); // renvoie en JSON
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'caracteristique' => ['required', 'string'],
            'prix' => ['required', 'numeric', 'min:0'],
            'image' => ['nullable', 'string', 'max:255'],
        ]);

        $prestation = Prestation::create($validated);

        return response()->json($prestation, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Prestation $prestation): JsonResponse
    {
        return response()->json($prestation);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Prestation $prestation): JsonResponse
    {
        $validated = $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'caracteristique' => ['required', 'string'],
            'prix' => ['required', 'numeric', 'min:0'],
            'image' => ['nullable', 'string', 'max:255'],
        ]);

        $prestation->update($validated);

        return response()->json($prestation);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Prestation $prestation): JsonResponse
    {
        $prestation->delete();

        return response()->json([
            'message' => 'Prestation supprimée avec succès',
        ]);
    }
}
