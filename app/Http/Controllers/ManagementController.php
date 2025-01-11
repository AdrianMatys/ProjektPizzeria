<?php

namespace App\Http\Controllers;

use App\Actions\Logs\LogUpdatePizzeriaAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdatePizzeriaRequest;
use App\Models\Pizzeria;

class ManagementController extends Controller
{
    public function index()
    {
        $pizzeria = Pizzeria::first();
        return view('management.admin.pizzeria.index', compact('pizzeria'));
    }

    public function edit(Pizzeria $pizzeria)
    {
        return view('management.admin.pizzeria.edit', compact('pizzeria'));
    }

    public function update(
        UpdatePizzeriaRequest $request,
        Pizzeria $pizzeria,
        LogUpdatePizzeriaAction $logUpdatePizzeriaAction
    ) {
        $validated = $request->validated();
        $pizzeria->update($validated);

        $logUpdatePizzeriaAction->execute(auth()->id(), ['pizzeria' => $validated]);

        return redirect()->route('management.admin.pizzeria.index')->with('success', 'Zaktualizowano dane pizzerii');
    }
}
