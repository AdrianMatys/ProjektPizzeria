<?php

namespace App\Actions\Orders;

use App\Models\CartItem;
use App\Models\Ingredient;
use App\Models\Order;
use Illuminate\Database\Eloquent\Collection;


class CheckIngredientQuantityAction
{
    private array $requiredIngredientsQuantity = [];
    public function __construct()
    {}
    public function hasEnough(Collection $cartItems): bool
    {

        foreach ($cartItems as $cartItem){
            $this->countRequiredIngredientsQuantity($cartItem);
        }
        foreach ($this->requiredIngredientsQuantity as $ingredientId => $quantity){
            $ingredient = Ingredient::query()->where('id', $ingredientId)->first();
            if($ingredient->quantity < $quantity) return false;
        }
        return true;
    }
    private function countRequiredIngredientsQuantity(CartItem $cartItem): void
    {
        $item = $cartItem->item;
        $ingredients = $item->ingredients;
        foreach ($ingredients as $ingredient){
            $this->requiredIngredientsQuantity[$ingredient->id] =
                ($this->requiredIngredientsQuantity[$ingredient->id] ?? 0) + ($ingredient->quantityOnPizza * $cartItem->quantity);
        }
    }
}
