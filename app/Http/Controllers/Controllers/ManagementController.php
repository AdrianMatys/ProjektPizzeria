<?php

namespace App\Http\Controllers\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Pizzeria;

class ManagementController extends Controller
{
    public function index(){
        $pizzeria = Pizzeria::first();
        return view('pizzeria.management.index', compact('pizzeria'));
    }
}
