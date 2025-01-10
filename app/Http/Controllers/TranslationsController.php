<?php

namespace App\Http\Controllers;

use App\Actions\Logs\LogCreateTranslationAction;
use App\Actions\Logs\LogDeleteTranslationAction;
use App\Actions\Logs\LogUpdateTranslationAction;
use App\Http\Requests\CreateTranslationRequest;
use App\Http\Requests\UpdateTranslationRequest;
use App\Models\Ingredient;
use App\Models\Translation;
use Illuminate\Http\Request;

class TranslationsController extends Controller
{
    public function index()
    {
        $translations = Translation::query()->get();
        $translations = $translations->unique('ingredient_id');
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
    public function create(Translation $translation)
    {
        $ingredients = Ingredient::query()->get();
        return view('management.employee.translations.create', compact('ingredients'));
    }
    public function update(UpdateTranslationRequest $request, Translation $translation, LogUpdateTranslationAction $logUpdateTranslationAction){
        $validated = $request->validated();
        $translation->update($validated);
        $logUpdateTranslationAction->execute(auth()->id(), ['name' => $translation->name]);
        $translations = Translation::query()->where('ingredient_id', $translation->ingredient_id)->get();
        return view('management.employee.translations.show', compact('translations'))->with('success', 'Zaktualizowano tłumaczenie');

    }
    public function store(CreateTranslationRequest $request, LogCreateTranslationAction $logCreateTranslationAction){
        $validated = $request->validated();
        $ingredientTranslation = Translation::query()
            ->where('ingredient_id', $validated['ingredient_id'])
            ->where('language_code', $validated['language_code'])
            ->get();
        if($ingredientTranslation->isNotEmpty()){
            return redirect()->back()->with('error', 'Tłumaczenie tego składnika w tym języku już istnieje');

        }
        $translation = Translation::create($validated);
        $logCreateTranslationAction->execute(auth()->id(), [
            'ingredientName' => $translation->ingredient->name,
            'language_code' => $translation->language_code,
            'name' => $translation->name
        ]);
        return redirect()->route('management.employee.translations.index')->with('success', 'Dodano nowe tłumaczenie');

    }
    public function destroy(Translation $translation, LogDeleteTranslationAction $logDeleteTranslationAction){
        $logDeleteTranslationAction->execute(auth()->id(),
            [
                'name' => $translation->name,
                'language_code' => $translation->language_code
            ]);
        $translation->delete();
        return redirect()->route('management.employee.translations.index')->with('success', 'Tłumaczenie zostało usunięte');
    }
}
