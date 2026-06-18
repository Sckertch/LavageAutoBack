<?php

use App\Http\Controllers\PrestationController;
use App\Http\Controllers\ProduitController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('prestations', [PrestationController::class, 'index']);
Route::get('produits', [ProduitController::class, 'index']);

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('prestations', PrestationController::class)->except(['index']);
    Route::apiResource('produits', ProduitController::class)->except(['index']);
});
