<?php

namespace App\Http\Controllers;

use App\Actions\Logs\LogNewPizzaAction;
use App\Actions\Logs\LogUpdateIngredientAction;
use App\Http\Requests\UpdateIngredientRequest;
use App\Models\Ingredient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class IngredientsController extends Controller
{

    public function index()
    {
        $locale = app()->getLocale();
        $ingredients = Ingredient::query()->with('translations')->orderBy('name')->get();

        foreach ($ingredients as $ingredient) {
            $translation = $ingredient->translations->firstWhere('language_code', $locale);
            if ($translation) {
                $ingredient['name'] = $translation->name;
            }
        }

        return view('management.employee.ingredients.index', compact('ingredients'));
    }

    public function create(Ingredient $ingredient)
    {
        return view('management.employee.ingredients.create', compact('ingredient'));
    }

    public function edit(Ingredient $ingredient)
    {
        return view('management.employee.ingredients.edit', compact('ingredient'));
    }

    public function destroy($id, LogNewPizzaAction $logDeletedIngredientAction)
    {
        $ingredient = Ingredient::query()->find($id);

        if (!$ingredient) {
            return redirect()->route('management.employee.ingredients.index')
                ->with('error', __('employee.failedRemoveIngredient'));
        }

        $logDeletedIngredientAction->execute(auth()->id(), ['ingredientName' => $ingredient->name]);
        $ingredient->delete();

        return redirect()->route('management.employee.ingredients.index')->with('success', __('employee.ingredientRemoved'));
    }

    public function update(
        UpdateIngredientRequest $request,
        Ingredient $ingredient,
        LogUpdateIngredientAction $logUpdateIngredientAction
    ) {
        $validated = $request->validated();
        $ingredient->update($validated);

        $logUpdateIngredientAction->execute(auth()->id(), ['ingredientName' => $ingredient->name]);

        return redirect()->route('management.employee.ingredients.index')
            ->with('success', __('employee.ingredientUpdated'));

    }

    public function store(UpdateIngredientRequest $request, LogNewPizzaAction $logNewIngredientAction)
    {
        $validated = $request->validated();
        $ingredient = Ingredient::create($validated);

        $logNewIngredientAction->execute(auth()->id(), ['ingredientName' => $ingredient->name]);

        return redirect()->route('management.employee.ingredients.index')
            ->with('success', __('employee.ingredientAdded'));

    }

}
