<?php

use App\Http\Controllers\PrestationController;
use App\Http\Controllers\ProduitController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DevisController;

// ── Routes publiques ──
Route::get('prestations', [PrestationController::class, 'index']);
Route::get('produits', [ProduitController::class, 'index']);
Route::post('login', [AuthController::class, 'login']);
Route::get('/devis/{devis}/pdf', [DevisController::class, 'downloadPublic']);

Route::middleware('throttle:devis')->post('devis', [DevisController::class, 'store']);

// ── Routes admin ──
Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::apiResource('prestations', PrestationController::class)->except(['index']);
    Route::apiResource('produits', ProduitController::class)->except(['index']);

    Route::get('devis', [DevisController::class, 'index']);
    Route::get('devis/{devis}', [DevisController::class, 'show']);
    Route::get('devis/{devis}/download', [DevisController::class, 'download']);
    Route::patch('devis/{devis}/statut', [DevisController::class, 'updateStatut']);
});

