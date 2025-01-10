<?php

namespace App\Http\Controllers;

use App\Actions\Logs\LogUpdateTranslationAction;
use App\Http\Requests\UpdateTranslationRequest;
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
    public function edit(Translation $translation)
    {
        return view('management.employee.translations.edit', compact('translation'));
    }
    public function update(UpdateTranslationRequest $request, Translation $translation){
        $validated = $request->validated();
        $translation->update($validated);

        $translations = Translation::query()->where('ingredient_id', $translation->ingredient_id)->get();
        return view('management.employee.translations.show', compact('translations'))->with('success', 'Zaktualizowano tłumaczenie');

    }
}
