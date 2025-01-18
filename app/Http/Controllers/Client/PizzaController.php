<?php

namespace App\Http\Controllers\Client;

use App\Actions\Carts\CreateCustomPizzaAction;
use App\Actions\Carts\CreateEditedPizzaAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\ClientModifyPizzaRequest;
use App\Http\Requests\UpdatePizzaRequest;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\CustomPizza;
use App\Models\CustomPizzaIngredient;
use App\Models\EditedPizza;
use App\Models\EditedPizzaIngredients;
use App\Models\Ingredient;
use App\Models\Pizza;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class PizzaController extends Controller
{


    public function create(Pizza $pizza)
    {
        $locale = App::getLocale();
        $ingredients = Ingredient::query()
            ->with([
                'translations' => function ($query) use ($locale) {
                    $query->where('language_code', $locale);
                }
            ])
            ->get();
        return view('client.pizza.create', compact('pizza', 'ingredients'));
    }
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

    public function store(ClientModifyPizzaRequest $request, CreateCustomPizzaAction $createCustomPizzaAction){
        $user_id = $request->user()->id;

        if (!$user_id) {
            return response()->json(['error' => __('client.userNotFound')], 401);
        }

        $validated = $request->validated();
        $newIngredients = $validated['ingredient'];
        $createCustomPizzaAction->execute($newIngredients);

        return redirect()->route('client.menu.index')->with('success', __('client.addedCustomPizza'));
    }

    public function update(ClientModifyPizzaRequest $request, Pizza $pizza, CreateEditedPizzaAction $createEditedPizzaAction)
    {
        $user_id = $request->user()->id;

        if (!$user_id) {
            return response()->json(['error' => __('client.userNotFound')], 401);
        }
        $validated = $request->validated();
        $newIngredients = $validated['ingredient'];

        $createEditedPizzaAction->execute($newIngredients, $pizza);

        return redirect()->route('client.menu.index')->with('success', __('client.addedEditedPizza'));
    }

}
