<?php

namespace App\Http\Requests\CaseProduct;

use Illuminate\Foundation\Http\FormRequest;

class StoreCaseProductRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'description' => ['required', 'string', 'min:5', 'max:300'],
            'quantity' => ['required', 'numeric', 'min:0.01', 'max:999999.99'],
            'supply_item_id' => ['nullable', 'integer', 'exists:supply_items,id'],
            'presentation_code' => ['nullable', 'integer'],
        ];
    }

    public function messages(): array
    {
        return [
            'description.required' => 'La descripcion del producto es necesaria.',
            'description.min' => 'Utiliza al menos 5 caracteres.',
            'quantity.required' => 'La cantidad es necesaria.',
            'quantity.min' => 'La cantidad debe ser mayor a cero.',
            'quantity.max' => 'La cantidad excede el maximo permitido.',
        ];
    }
}