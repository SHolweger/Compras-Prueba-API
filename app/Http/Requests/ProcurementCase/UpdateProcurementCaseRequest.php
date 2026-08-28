<?php

namespace App\Http\Requests\ProcurementCase;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProcurementCaseRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'unit_id' => ['sometimes', 'integer', 'exists:units,id'],
            'title' => ['sometimes', 'string', 'min:5', 'max:150'],
            'description' => ['sometimes', 'string', 'min:5'],
            'justification' => ['sometimes', 'string', 'min:5'],
        ];
    }
    
    public function messages(): array
    {
        return [
            'unit_id.exists' => 'La unidad seleccionada no existe',
            'title.min' => 'Utiliza al menos 5 caracteres para el título',
            'description.min' => 'La descripción debe tener al menos 5 caracteres.',
            'justification.min' => 'La justificación debe tener al menos 5 caracteres.',
        ];
    }
}