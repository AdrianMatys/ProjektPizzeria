<?php

namespace App\Http\Controllers;

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
        return view('client.menu.index', compact('pizzas'));
    }

}
