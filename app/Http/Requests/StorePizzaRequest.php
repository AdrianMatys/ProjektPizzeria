<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePizzaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:pizzas,name',
            'price' => 'required|numeric|min:0',
            'ingredient' => 'required|array|min:1',
            'ingredient.*' => 'required|exists:ingredients,id',
            'quantity' => 'required|array|min:1',
            'quantity.*' => 'required|integer|min:1|max:1000000',
        ];
    }
}
