<?php

namespace App\Http\Controllers;

use App\Models\Prestation;
use Illuminate\Http\Request;

class PrestationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // GET /api/prestations → retourne toutes les prestations
    public function index()
    {
        $prestations = Prestation::all(); // récupère tout en BDD
        return response()->json($prestations); // renvoie en JSON
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
