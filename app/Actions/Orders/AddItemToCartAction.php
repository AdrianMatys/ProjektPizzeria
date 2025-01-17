<?php

namespace App\Actions\Orders;

use App\Http\Requests\AddItemToCartRequest;
use App\Models\Cart;
use App\Models\CartItem;
use App\Services\LoggerService;

class AddItemToCartAction
{
    public function execute(array $item): void
    {
        $cart = Cart::query()->firstOrCreate(['user_id' => auth()->id()]);

        $cartItem = CartItem::query()->where(
            [
                'cart_id' => $cart->id,
                'item_id' => $item['item_id'],
                'item_type' => $item['item_type'],
            ])
            ->first();

        if ($cartItem) {
            $cartItem->quantity += $item['quantity'];
            $cartItem->save();
        } else {
            CartItem::query()->create([
                'cart_id' => $cart->id,
                'item_id' => $item['item_id'],
                'item_type' => $item['item_type'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }
    }

}
