<?php

namespace App\Http\Controllers;

use App\Models\ProcurementCase;
use App\Services\ProcurementCaseService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProcurementCaseController extends Controller
{
    public function __construct(protected ProcurementCaseService $service) {}

    public function index()
    {
        return response()->json($this->service->list());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'status_id' => ['required', 'integer', 'exists:statuses,id'],
            'unit_id' => ['required', 'integer', 'exists:units,id'],
            'user_id' => ['required', 'integer'],
            'tray_id' => ['nullable', 'integer', 'exists:trays,id'],
            'modality_id' => ['nullable', 'integer', 'exists:modalities,id'],
            'budget_object_id' => ['nullable', 'integer', 'exists:budget_objects,id'],
            'supplier_id' => ['nullable', 'integer', 'exists:suppliers,id'],
            'form_number' => ['nullable', 'string', 'max:45', 'unique:procurement_cases,form_number'],
            'title' => ['nullable', 'string', 'max:150'],
            'description' => ['nullable', 'string'],
            'justification' => ['nullable', 'string'],
            'nog_number' => ['nullable', 'string', 'max:45'],
            'amount' => ['nullable', 'numeric'],
            'submitted_at' => ['nullable', 'date'],
            'completed_at' => ['nullable', 'date'],
            'check_number' => ['nullable', 'string', 'max:150'],
            'budget_line_reference' => ['nullable', 'string', 'max:50'],
            'is_suspended' => ['nullable', 'boolean'],
            'is_endorsed' => ['nullable', 'boolean'],
            'responsible_user_id' => ['nullable', 'integer'],
        ]);

        return response()->json($this->service->create($data), 201);
    }

    public function show(ProcurementCase $procurementCase)
    {
        return response()->json($this->service->find($procurementCase->id));
    }

    public function update(Request $request, ProcurementCase $procurementCase)
    {
        $data = $request->validate([
            'status_id' => ['sometimes', 'integer', 'exists:statuses,id'],
            'unit_id' => ['sometimes', 'integer', 'exists:units,id'],
            'user_id' => ['sometimes', 'integer'],
            'tray_id' => ['nullable', 'integer', 'exists:trays,id'],
            'modality_id' => ['nullable', 'integer', 'exists:modalities,id'],
            'budget_object_id' => ['nullable', 'integer', 'exists:budget_objects,id'],
            'supplier_id' => ['nullable', 'integer', 'exists:suppliers,id'],
            'form_number' => ['nullable', 'string', 'max:45', Rule::unique('procurement_cases', 'form_number')->ignore($procurementCase->id)],
            'title' => ['nullable', 'string', 'max:150'],
            'description' => ['nullable', 'string'],
            'justification' => ['nullable', 'string'],
            'nog_number' => ['nullable', 'string', 'max:45'],
            'amount' => ['nullable', 'numeric'],
            'submitted_at' => ['nullable', 'date'],
            'completed_at' => ['nullable', 'date'],
            'check_number' => ['nullable', 'string', 'max:150'],
            'budget_line_reference' => ['nullable', 'string', 'max:50'],
            'is_suspended' => ['nullable', 'boolean'],
            'is_endorsed' => ['nullable', 'boolean'],
            'responsible_user_id' => ['nullable', 'integer'],
        ]);

        return response()->json($this->service->update($procurementCase, $data));
    }

    public function destroy(ProcurementCase $procurementCase)
    {
        $this->service->delete($procurementCase);

        return response()->json(null, 204);
    }
}
