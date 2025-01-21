<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Ingredient;
use App\Models\Order;
use App\Models\Pizza;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class employeePanelController extends Controller
{
    // orders menumanagemnet
    public function index()
    {
        $locale = App::getLocale();
        $pizzas = Pizza::query()
            ->with(['ingredients.translations' => function ($query) use ($locale) {
                $query->where('language_code', $locale);
            }])
            ->get();
        $groupedOrders = Order::query()->get()->groupBy('status');

        $locale = App::getLocale();
        $ingredients = Ingredient::query()
            ->with(['translations' => function ($query) use ($locale){
                $query->where('language_code', $locale);
            }])
            ->get();

        return view('management.employee.panel.index', compact('groupedOrders', 'pizzas', 'ingredients'));

    }
}
