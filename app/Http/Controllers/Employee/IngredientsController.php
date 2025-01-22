<?php

namespace App\Http\Controllers\Employee;

use App\Actions\Logs\LogCreateIngredient;
use App\Actions\Logs\LogDeletedIngredientAction;
use App\Actions\Logs\LogUpdateIngredientAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateIngredientRequest;
use App\Http\Requests\UpdateIngredientRequest;
use App\Models\Ingredient;

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

    public function destroy($id, LogDeletedIngredientAction $logDeletedIngredientAction)
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

        $logUpdateIngredientAction->execute(auth()->id(), ['Ingredient name' => $ingredient->name]);

        return redirect()->route('management.employee.ingredients.index')
            ->with('success', __('employee.ingredientUpdated'));

    }

    public function store(CreateIngredientRequest $request, LogCreateIngredient $logCreateIngredient)
    {
        $validated = $request->validated();
        $ingredient = Ingredient::create($validated);

        $logCreateIngredient->execute(auth()->id(), ['Ingredient name' => $ingredient->name]);

        return redirect()->route('management.employee.ingredients.index')
            ->with('success', __('employee.ingredientAdded'));

    }

}
