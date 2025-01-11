<?php

namespace App\Actions\Orders;

use App\Models\CartItem;
use App\Models\Order;
use Illuminate\Database\Eloquent\Collection;


class CreateOrderItemsFromCartItemsAction
{
    public function __construct(private CreateOrderItemAction $createOrderItemAction)
    {}
    public function execute(Collection $cartItems, int $cartId): void
    {
        $totalPrice = 0;

        $order = Order::create([
            'user_id' => auth()->id(),
            'status' => 'pending',
            'total_price' => 0,
        ]);

        foreach ($cartItems as $cartItem){
            $totalPrice += $cartItem->price * $cartItem->quantity;
            $this->createOrderItemAction->execute($cartItem, $order->id);
        }

        CartItem::query()
            ->where('cart_id', $cartId)
            ->delete();

        $order->update(['total_price' => $totalPrice]);
    }
}
