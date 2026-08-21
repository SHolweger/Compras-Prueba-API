<?php

namespace App\Http\Controllers;

use App\Models\CaseTask;
use App\Services\CaseTaskService;
use Illuminate\Http\Request;

class CaseTaskController extends Controller
{
    public function __construct(protected CaseTaskService $service) {}

    public function index()
    {
        return response()->json($this->service->list());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'procurement_case_id' => ['required', 'integer', 'exists:procurement_cases,id'],
            'task_id' => ['required', 'integer', 'exists:tasks,id'],
            'starts_on' => ['nullable', 'date'],
            'ends_on' => ['nullable', 'date'],
            'notes' => ['nullable', 'string'],
            'user_id' => ['nullable', 'integer'],
        ]);

        return response()->json($this->service->create($data), 201);
    }

    public function show(CaseTask $caseTask)
    {
        return response()->json($this->service->find($caseTask->id));
    }

    public function update(Request $request, CaseTask $caseTask)
    {
        $data = $request->validate([
            'procurement_case_id' => ['sometimes', 'integer', 'exists:procurement_cases,id'],
            'task_id' => ['sometimes', 'integer', 'exists:tasks,id'],
            'starts_on' => ['nullable', 'date'],
            'ends_on' => ['nullable', 'date'],
            'notes' => ['nullable', 'string'],
            'user_id' => ['nullable', 'integer'],
        ]);

        return response()->json($this->service->update($caseTask, $data));
    }

    public function destroy(CaseTask $caseTask)
    {
        $this->service->delete($caseTask);

        return response()->json(null, 204);
    }
}
