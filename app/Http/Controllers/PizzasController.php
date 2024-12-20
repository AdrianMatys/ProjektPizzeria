<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdatePizzaRequest;
use App\Http\Requests\UpdatePizzeriaRequest;
use App\Models\Ingredient;
use App\Models\Pizza;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class PizzasController extends Controller
{
    public function index(){
        $locale = App::getLocale();
        $pizzas = Pizza::query()
            ->with(['ingredients.translations' => function ($query) use ($locale) {
                $query->where('language_code', $locale);
            }])
            ->get();
        return view('management.employee.pizzas.index', compact('pizzas'));
    }



    public function create(Pizza $pizza)
    {
        $locale = App::getLocale();
        $ingredients = Ingredient::query()
            ->with(['translations' => function ($query) use ($locale){
                $query->where('language_code', $locale);
            }])
            ->get();
        return view('management.employee.pizzas.create', compact('pizza', 'ingredients'));
    }

    public function edit(Pizza $pizza)
    {
        $locale = App::getLocale();
        $ingredients = Ingredient::query()
            ->with(['translations' => function ($query) use ($locale){
                $query->where('language_code', $locale);
            }])
            ->get();
        return view('management.employee.pizzas.edit', compact('pizza', 'ingredients'));
    }

    public function destroy($id){
        $pizza = Pizza::query()->find($id);
        if(!$pizza)
            return redirect()->route('management.employee.pizzas.index')->with('error', 'Nie udało się usunąć pizzy');

        $pizza->delete();
        return redirect()->route('management.employee.pizzas.index')->with('success', 'Pizza została usunięta');
    }

    public function update(UpdatePizzaRequest $request, Pizza  $pizza){
        $validated = $request->validated();
        $pizza->update($validated);
        $pizza->ingredients()->detach();


        foreach ($validated['ingredient'] as $index=>$ingredientId){
            $pizza->ingredients()->attach($ingredientId, [
                'quantity' => $validated['quantity'][$index],
            ]);
        }

        return redirect()->route('management.employee.pizzas.index')->with('success', 'Zaktualizowano pizze');
    }

    public function store(UpdatePizzaRequest $request, Pizza  $pizza){
        $validated = $request->validated();
        $pizza = Pizza::create($validated);

        foreach ($validated['ingredient'] as $index=>$ingredientId){
            $pizza->ingredients()->attach($ingredientId, [
               'quantity' => $validated['quantity'][$index],
            ]);
        }

        return redirect()->route('management.employee.pizzas.index')->with('success', 'Dodano nową pizze');
    }
}
