<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Pizza;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class DisplayMenuController extends Controller
{
    public function index()
    {
        $locale = App::getLocale();

        $pizzas = Pizza::query()
            ->with([
                'ingredients.translations' => function ($query) use ($locale) {
                    $query->where('language_code', $locale);
                }
            ])
            ->get();

        foreach ($pizzas as $pizza) {
            foreach ($pizza->ingredients as $ingredient) {
                if ($ingredient->quantityOnPizza > $ingredient->quantity) {
                    $pizza->unavailable = true;
                }
            }
        }

        return view('client.menu.index', compact('pizzas'));
    }

}
