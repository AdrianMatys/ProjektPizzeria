<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddItemToCartRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'item_id' => ['required', 'integer'],
            'item_type' => ['required', 'string', 'in:Pizza,CustomPizza,EditedPizza'],
            'quantity' => ['required', 'min:1', 'max:100'],
            'price' => ['required', 'numeric', 'min:0.01'],
        ];
    }
}
