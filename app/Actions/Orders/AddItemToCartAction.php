<?php

namespace App\Actions\Orders;

use App\Http\Requests\AddItemToCartRequest;
use App\Models\Cart;
use App\Models\CartItem;
use App\Services\LoggerService;

class AddItemToCartAction
{
    public function execute(AddItemToCartRequest $request): void
    {
        $cart = Cart::query()->firstOrCreate(['user_id' => auth()->id()]);

        $cartItem = CartItem::query()->where(
            [
                'cart_id' => $cart->id,
                'item_id' => $request->item_id,
                'item_type' => $request->item_type,
            ])
            ->first();

        if ($cartItem) {
            $cartItem->quantity += $request->quantity;
            $cartItem->save();
        } else {
            CartItem::query()->create([
                'cart_id' => $cart->id,
                'item_id' => $request->item_id,
                'item_type' => $request->item_type,
                'quantity' => $request->quantity,
                'price' => $request->price,
            ]);
        }
    }

}
