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
use Illuminate\Support\Facades\Cache;

class CreateOrderItemAction
{
    private bool $isNotifyOnCooldown = false;
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
        $this->isNotifyOnCooldown = false;
    }

    private function checkLowStock(int $ingredientId): void
    {
        $Ingredient = Ingredient::query()
            ->where('id', $ingredientId)
            ->first();
        if ($Ingredient->quantity < $Ingredient->minQuantity) return;
        if($this->isIngredientNotifyOnCooldown($Ingredient->id)) return;
        if($this->isNotifyOnCooldown) return;

        Artisan::call('notify:low-stock');
        $this->isNotifyOnCooldown = true;
    }
    private function isIngredientNotifyOnCooldown(int $ingredientId): bool
    {
        return !Cache::add('notifyCooldown:' . $ingredientId, true, now()->addDay());
    }
    private function usingUpIngredients(Ingredient $ingredient, int $cartItemQuantity): void
    {
        $totalQuantity = $ingredient->quantityOnPizza * $cartItemQuantity;

        Ingredient::query()
            ->where('id', $ingredient->id)
            ->decrement('quantity', $totalQuantity);
    }

}
