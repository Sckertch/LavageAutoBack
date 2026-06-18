<?php

use App\Http\Controllers\PrestationController;
use App\Http\Controllers\ProduitController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('prestations', [PrestationController::class, 'index']);
Route::get('produits', [ProduitController::class, 'index']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::apiResource('prestations', PrestationController::class)->except(['index']);
    Route::apiResource('produits', ProduitController::class)->except(['index']);
});
