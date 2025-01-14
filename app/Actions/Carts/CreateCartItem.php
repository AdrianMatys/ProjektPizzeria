<?php

namespace App\Actions\Carts;

use App\Models\CartItem;

class CreateCartItem
{
    public function execute(int $cartId, int $itemId, string $itemType, int $quantity, float $totalPrice): CartItem
    {
        return CartItem::query()->create([
            'cart_id' => $cartId,
            'item_id' => $itemId,
            'item_type' => $itemType,
            'quantity' => $quantity,
            'price' => $totalPrice,
        ]);
    }


}
