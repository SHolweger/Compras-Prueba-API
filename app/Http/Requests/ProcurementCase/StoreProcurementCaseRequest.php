<?php

namespace App\Http\Requests\ProcurementCase;

use Illuminate\Foundation\Http\FormRequest;

class StoreProcurementCaseRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'unit_id' => [ 'required', 'integer', 'exists:units,id'],
            'title' => ['required', 'string', 'min:5', 'max:150'],
            'description' => ['required', 'string', 'min:5'],
            'justification' => ['required', 'string', 'min:5'],
        ];
    }

    public function messages(): array
    {
        return [
            'unit_id.required' => 'Selecciona la unidad que solicita.',
            'unit_id.exists' => 'La unidad seleccionada no existe',
            'title.required' => 'El título de la compra es necesario.',
            'title.min' => 'Utiliza al menos 5 caracteres para el título',
            'description.required' => 'La descripción de la compra es necesaria.',
            'description.min' => 'La descripción debe tener al menos 5 caracteres.',
            'justification.required' => 'La justificacion de la compra es necesaria.',
            'justification.min' => 'La justificación debe tener al menos 5 caracteres.',
        ];
    }
}