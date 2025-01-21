<?php

namespace App\Http\Controllers\Employee;

use App\Actions\Logs\LogDeletedPizzaAction;
use App\Actions\Logs\LogNewPizzaAction;
use App\Actions\Logs\LogUpdatePizzaAction;
use App\Actions\Pizzas\CreatePizzaAsEmployeeAction;
use App\Actions\Pizzas\UpdatePizzaAsEmployeeAction;
use App\Http\Controllers\Controller;
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
        return view('management.employee.panel.create', compact('pizza', 'ingredients'));
    }

    public function edit(Pizza $pizza)
    {
        $locale = App::getLocale();
        $ingredients = Ingredient::query()
            ->with(['translations' => function ($query) use ($locale){
                $query->where('language_code', $locale);
            }])
            ->get();
        return view('management.employee.panel.edit', compact('pizza', 'ingredients'));
    }

    public function destroy($id, LogDeletedPizzaAction $logDeletedPizzaAction){
        $pizza = Pizza::query()->find($id);
        if(!$pizza)
            return redirect()->route('management.employee.pizzas.index')->with('error', __('employee.failedRemovePizza'));

        $logDeletedPizzaAction->execute(auth()->id(), ['Pizza name' => $pizza->name]);
        $pizza->delete();
        return redirect()->route('management.employee.panel.index')->with('success', __('employee.pizzaRemoved'));
    }

    public function update(UpdatePizzaRequest $request, Pizza  $pizza, LogUpdatePizzaAction $logUpdatePizzaAction, UpdatePizzaAsEmployeeAction $updatePizzaAsEmployeeAction){
        $validated = $request->validated();

        $updatePizzaAsEmployeeAction->execute($validated, $pizza);
        $logUpdatePizzaAction->execute(auth()->id(), ['pizza' => $validated]);

        return redirect()->route('management.employee.panel.index')->with('success', __('employee.pizzaUpdated'));
    }

    public function store(UpdatePizzaRequest $request, Pizza  $pizza, LogNewPizzaAction $logNewPizzaAction, CreatePizzaAsEmployeeAction $createPizzaAsEmployeeAction){
        $validated = $request->validated();

        $createPizzaAsEmployeeAction->execute($validated);
        $logNewPizzaAction->execute(auth()->id(), ['Pizza name' => $validated['name'], 'Ingredients' => $validated['ingredient']]);

        return redirect()->route('management.employee.panel.index')->with('success', __('employee.pizzaAdded'));
    }
}
