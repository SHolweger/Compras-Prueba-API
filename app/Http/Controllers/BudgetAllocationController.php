<?php

namespace App\Http\Controllers;

use App\Models\BudgetAllocation;
use App\Services\BudgetAllocationService;
use Illuminate\Http\Request;

class BudgetAllocationController extends Controller
{
    public function __construct(protected BudgetAllocationService $service) {}

    public function index()
    {
        return response()->json($this->service->list());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'procurement_case_id' => ['required', 'integer', 'exists:procurement_cases,id'],
            'name' => ['required', 'string', 'max:100'],
            'program_code' => ['nullable', 'string', 'max:2'],
            'subprogram_code' => ['nullable', 'string', 'max:2'],
            'project_code' => ['nullable', 'string', 'max:3'],
            'activity_code' => ['nullable', 'string', 'max:3'],
            'work_code' => ['nullable', 'string', 'max:3'],
            'function_code' => ['nullable', 'string', 'max:2'],
            'object_code' => ['nullable', 'string', 'max:3'],
            'funding_source_code' => ['nullable', 'string', 'max:2'],
            'funding_org_code' => ['nullable', 'string', 'max:4'],
            'specific_fund_code' => ['nullable', 'string', 'max:4'],
        ]);

        return response()->json($this->service->create($data), 201);
    }

    public function show(BudgetAllocation $budgetAllocation)
    {
        return response()->json($this->service->find($budgetAllocation->id));
    }

    public function update(Request $request, BudgetAllocation $budgetAllocation)
    {
        $data = $request->validate([
            'procurement_case_id' => ['sometimes', 'integer', 'exists:procurement_cases,id'],
            'name' => ['sometimes', 'string', 'max:100'],
            'program_code' => ['nullable', 'string', 'max:2'],
            'subprogram_code' => ['nullable', 'string', 'max:2'],
            'project_code' => ['nullable', 'string', 'max:3'],
            'activity_code' => ['nullable', 'string', 'max:3'],
            'work_code' => ['nullable', 'string', 'max:3'],
            'function_code' => ['nullable', 'string', 'max:2'],
            'object_code' => ['nullable', 'string', 'max:3'],
            'funding_source_code' => ['nullable', 'string', 'max:2'],
            'funding_org_code' => ['nullable', 'string', 'max:4'],
            'specific_fund_code' => ['nullable', 'string', 'max:4'],
        ]);

        return response()->json($this->service->update($budgetAllocation, $data));
    }

    public function destroy(BudgetAllocation $budgetAllocation)
    {
        $this->service->delete($budgetAllocation);

        return response()->json(null, 204);
    }
}
