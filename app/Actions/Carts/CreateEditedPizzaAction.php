<?php

namespace App\Actions\Carts;

use App\Actions\Orders\CreateOrderItemAction;
use App\Http\Requests\ClientModifyPizzaRequest;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\EditedPizza;
use App\Models\EditedPizzaIngredients;
use App\Models\Ingredient;
use App\Models\Pizza;
use Illuminate\Database\Eloquent\Collection;

class CreateEditedPizzaAction
{

    public function __construct(private CreateCartItem $createCartItem)
    {}
    public function execute(array $newIngredients, Pizza $pizza): void
    {
        $cart = Cart::query()->firstOrCreate(['user_id' => auth()->id()]);

        $editedPizza = EditedPizza::create([
            'base_pizza_id' => $pizza->id,
        ]);

        [$addedIngredients, $removedIngredients] = $this->getIngredients($newIngredients, $pizza);

        $totalPrice = $pizza->price;
        $totalPrice += $this->calculateIngredientsPrice($addedIngredients);
        $totalPrice -= $this->calculateIngredientsPrice($removedIngredients);
        $this->createIngredients($addedIngredients, $editedPizza->id, 'added');
        $this->createIngredients($removedIngredients, $editedPizza->id, 'removed');

        $this->createCartItem->execute($cart->id, $editedPizza->id, 'EditedPizza', 1, $totalPrice);
    }

    /**
    * @return Collection<Ingredient>[]
    */
    private function getIngredients(array $newIngredients, Pizza $pizza): array
    {

        $addedIngredientIds = [];
        $existingIngredientIds = $pizza->ingredients()->select('ingredients.id')->pluck('id')->toArray();

        foreach ($newIngredients as $ingredient) {
            $index = array_search($ingredient, $existingIngredientIds);

            if ($index !== false) {
                unset($existingIngredientIds[$index]);
            } else {
                $addedIngredientIds[] = $ingredient;
            }
        }
        $removedIngredientIds = array_values($existingIngredientIds);

        $addedIngredients = Ingredient::query()->whereIn('id', $addedIngredientIds)->get();
        $removedIngredients = Ingredient::query()->whereIn('id', $removedIngredientIds)->get();
        return [$addedIngredients, $removedIngredients];
    }

    private function createIngredients(Collection $ingredients, int $editedPizzaId, string $status)
    {
        foreach ($ingredients as $ingredient) {
            $this->createEditedPizzaIngredient($editedPizzaId, $ingredient, $status);
        }
    }
    private function calculateIngredientsPrice(Collection $ingredients): float
    {
        $totalPrice = 0;
        foreach ($ingredients as $ingredient) {
            $totalPrice += $ingredient->price;
        }
        return $totalPrice;
    }

    private function createEditedPizzaIngredient(int $editedPizzaId, Ingredient $ingredient, string $action): void
    {
        EditedPizzaIngredients::create([
            'edited_pizza_id' => $editedPizzaId,
            'ingredient_id' => $ingredient->id,
            'action' => $action,
            'price' => $ingredient->price,
        ]);
    }

}
