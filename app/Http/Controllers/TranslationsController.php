<?php

namespace App\Http\Controllers;

use App\Models\Translation;
use Illuminate\Http\Request;

class TranslationsController extends Controller
{
    public function index()
    {
        $translations = Translation::query()->get();
        return view('management.employee.translations.index', compact('translations'));
    }
    public function show(Translation $translation)
    {
        $translations = $translation->ingredient->translations;
        return view('management.employee.translations.show', compact('translations'));
    }
}
