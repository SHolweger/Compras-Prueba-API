<?php

namespace App\Http\Controllers;

use App\Models\CaseLogEntry;
use App\Services\CaseLogEntryService;
use Illuminate\Http\Request;

class CaseLogEntryController extends Controller
{
    public function __construct(protected CaseLogEntryService $service) {}

    public function index()
    {
        return response()->json($this->service->list());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'procurement_case_id' => ['required', 'integer', 'exists:procurement_cases,id'],
            'tray_id' => ['required', 'integer', 'exists:trays,id'],
            'user_id' => ['required', 'integer'],
            'entered_at' => ['nullable', 'date'],
            'exited_at' => ['nullable', 'date'],
            'comment' => ['nullable', 'string', 'max:100'],
            'assigned_user_id' => ['nullable', 'integer'],
        ]);

        return response()->json($this->service->create($data), 201);
    }

    public function show(CaseLogEntry $caseLogEntry)
    {
        return response()->json($this->service->find($caseLogEntry->id));
    }

    public function update(Request $request, CaseLogEntry $caseLogEntry)
    {
        $data = $request->validate([
            'procurement_case_id' => ['sometimes', 'integer', 'exists:procurement_cases,id'],
            'tray_id' => ['sometimes', 'integer', 'exists:trays,id'],
            'user_id' => ['sometimes', 'integer'],
            'entered_at' => ['nullable', 'date'],
            'exited_at' => ['nullable', 'date'],
            'comment' => ['nullable', 'string', 'max:100'],
            'assigned_user_id' => ['nullable', 'integer'],
        ]);

        return response()->json($this->service->update($caseLogEntry, $data));
    }

    public function destroy(CaseLogEntry $caseLogEntry)
    {
        $this->service->delete($caseLogEntry);

        return response()->json(null, 204);
    }
}
