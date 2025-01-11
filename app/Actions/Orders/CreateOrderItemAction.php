<?php

namespace App\Actions\Orders;

use App\Http\Requests\AddItemToCartRequest;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Ingredient;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\LoggerService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Artisan;

class CreateOrderItemAction
{
    public function execute(CartItem $cartItem, int $orderId): void
    {
        OrderItem::create(
            [
                'order_id' => $orderId,
                'item_type' => $cartItem->item_type,
                'item_id' => $cartItem->item_id,
                'quantity' => $cartItem->quantity,
                'price' => $cartItem->price
            ]
        );

        $ingredients = $cartItem->item->ingredients;

        foreach ($ingredients as $ingredient) {
            $this->usingUpIngredients($ingredient, $cartItem->quantity);
            $this->checkLowStock($ingredient->id);
        }
    }

    private function checkLowStock(int $ingredientId): void
    {
        $dbIngredient = Ingredient::query()
            ->where('id', $ingredientId)
            ->first();

        if ($dbIngredient->quantity > 1000) {
            Artisan::call('notify:low-stock');
        }
    }

    private function usingUpIngredients(Ingredient $ingredient, int $cartItemQuantity)
    {
        $totalQuantity = $ingredient->quantityOnPizza * $cartItemQuantity;

        Ingredient::query()
            ->where('id', $ingredient->id)
            ->decrement('quantity', $totalQuantity);
    }

}
