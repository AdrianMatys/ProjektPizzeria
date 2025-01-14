<?php

namespace App\Actions\Carts;

use App\Http\Requests\AddItemToCartRequest;
use App\Http\Requests\ClientModifyPizzaRequest;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\CustomPizza;
use App\Models\CustomPizzaIngredient;
use App\Models\Ingredient;

class CreateCustomPizzaAction
{
    public function __construct(private CreateCartItem $createCartItem)
    {}
    public function execute(array $newIngredients): void
    {
        $cart = Cart::query()->firstOrCreate(['user_id' => auth()->id()]);

        $customPizza = CustomPizza::create();

        $totalPrice = 0;

        foreach ($newIngredients as $ingredientId) {
            $ingredient = Ingredient::query()->find($ingredientId);

            $this->createCustomPizzaIngredient($ingredient, $customPizza->id);

            $totalPrice += $ingredient->price;
        }
        $this->createCartItem->execute($cart->id, $customPizza->id, 'CustomPizza', 1, $totalPrice);
    }

    private function createCustomPizzaIngredient(Ingredient $ingredient, int $customPizzaId){
        CustomPizzaIngredient::create([
            'custom_pizza_id' => $customPizzaId,
            'ingredient_id' => $ingredient->id,
            'price' => $ingredient->price,
        ]);
    }

}
