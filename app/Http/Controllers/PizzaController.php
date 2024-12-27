<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientModifyPizzaRequest;
use App\Http\Requests\UpdatePizzaRequest;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\EditedPizza;
use App\Models\EditedPizzaIngredients;
use App\Models\Ingredient;
use App\Models\Pizza;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class PizzaController extends Controller
{


    public function edit(Pizza $pizza)
    {
        $locale = App::getLocale();
        $ingredients = Ingredient::query()
            ->with([
                'translations' => function ($query) use ($locale) {
                    $query->where('language_code', $locale);
                }
            ])
            ->get();
        return view('client.pizza.edit', compact('pizza', 'ingredients'));
    }


    public function update(ClientModifyPizzaRequest $request, Pizza $pizza)
    {
        $validated = $request->validated();
        $user_id = $request->user()->id;

        if (!$user_id) {
            return response()->json(['error' => 'Nie znaleziono użytkownika. Upewnij się, że jesteś zalogowany.'], 401);
        }
        $cart = Cart::query()->firstOrCreate(['user_id' => $user_id]);

        $editedPizza = EditedPizza::create([
            'base_pizza_id' => $pizza->id,
        ]);
        $existingIngredients = $pizza->ingredients()->select('ingredients.id')->pluck('id')->toArray();
        $newIngredients = $validated['ingredient'];

        $addedIngredients = array_values(array_diff($newIngredients, $existingIngredients));
        $removedIngredients = array_values(array_diff($existingIngredients, $newIngredients));

        foreach ($addedIngredients as $ingredientId) {
            EditedPizzaIngredients::create([
                'edited_pizza_id' => $editedPizza->id,
                'ingredient_id' => $ingredientId,
                'action' => 'added',
                'price' => 0,
            ]);
        }
        foreach ($removedIngredients as $ingredientId) {
            EditedPizzaIngredients::create([
                'edited_pizza_id' => $editedPizza->id,
                'ingredient_id' => $ingredientId,
                'action' => 'removed',
                'price' => 0,
            ]);
        }

        $cartItem = CartItem::query()->create([
            'cart_id' => $cart->id,
            'item_id' => $editedPizza->id,
            'item_type' => 'EditedPizza',
            'quantity' => 1,
            'price' => 0,
        ]);

        return redirect()->route('client.menu.index')->with('success', 'Dodano do koszyka zmodyfikowaną pizze');
    }


}
