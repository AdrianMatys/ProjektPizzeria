<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateIngredientRequest;
use App\Models\Ingredient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class IngredientsController extends Controller
{

    public function index(){
        $locale = app()->getLocale();
        $ingredients = Ingredient::query()->with('translations')->orderBy('name')->get();

       foreach ($ingredients as $ingredient){
           $translation = $ingredient->translations->firstWhere('language_code', $locale);
           if($translation)
            $ingredient['name'] =  $translation->name;
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

    public function destroy($id){
        $ingredient = Ingredient::query()->find($id);
        if(!$ingredient)
            return redirect()->route('management.employee.ingredients.index')->with('error', 'Nie udało się usunąć składnika');

        $ingredient->delete();
        return redirect()->route('management.employee.ingredients.index')->with('success', 'Składnik został usunięty');
    }

    public function update(UpdateIngredientRequest $request, Ingredient $ingredient){
        $validated = $request->validated();
        $ingredient->update($validated);
        return redirect()->route('management.employee.ingredients.index')->with('success', 'Zaktualizowano składnik');

    }

    public function store(UpdateIngredientRequest $request, Ingredient $ingredient){
        $validated = $request->validated();
        $ingredient = Ingredient::create($validated);
        return redirect()->route('management.employee.ingredients.index')->with('success', 'Dodano nowy składnik');

    }

}
