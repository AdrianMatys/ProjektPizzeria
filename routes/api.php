<?php

use App\Http\Controllers\Client\CartController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('cart/json', [CartController::class, 'getJson'])
        ->name('client.cart.json')
        ->middleware(['auth']);
});
