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
    public function execute(ClientModifyPizzaRequest $request, CreateCartItem $createCartItem): void
    {
        $validated = $request->validated();
        $newIngredients = $validated['ingredient'];
        $cart = Cart::query()->firstOrCreate(['user_id' => auth()->id()]);

        $customPizza = CustomPizza::create();

        $totalPrice = 0;

        foreach ($newIngredients as $ingredientId) {
            $ingredient = Ingredient::query()->find($ingredientId);

            $this->createCustomPizzaIngredient($ingredient, $customPizza->id);

            $totalPrice += $ingredient->price;
        }
        $createCartItem->execute($cart->id, $customPizza->id, 'CustomPizza', 1, $totalPrice);
    }

    private function createCustomPizzaIngredient(Ingredient $ingredient, int $customPizzaId){
        CustomPizzaIngredient::create([
            'custom_pizza_id' => $customPizzaId,
            'ingredient_id' => $ingredient->id,
            'price' => $ingredient->price,
        ]);
    }

}
