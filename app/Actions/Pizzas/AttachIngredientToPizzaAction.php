<?php

namespace App\Actions\Pizzas;

use App\Http\Requests\AddItemToCartRequest;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Pizza;
use App\Services\LoggerService;

class AttachIngredientToPizzaAction
{
    public function execute(array $ingredientIds,Pizza $pizza): void
    {
        foreach ($ingredientIds as $ingredientId){
            $pizza->ingredients()->attach($ingredientId);
        }
    }

}
