<?php

use App\Http\Controllers\CartController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('cart', [CartController::class, 'index'])->name('cart.index');

    Route::post('cart/add', [CartController::class, 'addToCart'])->name('cart.add');

    Route::delete('cart/remove/{itemId}', [CartController::class, 'removeItem'])->name('cart.remove');

    Route::put('cart/update/{itemId}', [CartController::class, 'updateItemQuantity'])->name('cart.update');
});
