<?php

namespace App\Http\Controllers;

use App\Models\BudgetAllocationObject;
use App\Services\BudgetAllocationObjectService;
use Illuminate\Http\Request;

class BudgetAllocationObjectController extends Controller
{
    public function __construct(protected BudgetAllocationObjectService $service) {}

    public function index()
    {
        return response()->json($this->service->list());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'procurement_case_id' => ['required', 'integer', 'exists:procurement_cases,id'],
            'budget_allocation_id' => ['required', 'integer', 'exists:budget_allocations,id'],
            'budget_object_id' => ['required', 'integer', 'exists:budget_objects,id'],
            'amount' => ['required', 'numeric'],
        ]);

        return response()->json($this->service->create($data), 201);
    }

    public function show(BudgetAllocationObject $budgetAllocationObject)
    {
        return response()->json($this->service->find($budgetAllocationObject->id));
    }

    public function update(Request $request, BudgetAllocationObject $budgetAllocationObject)
    {
        $data = $request->validate([
            'procurement_case_id' => ['sometimes', 'integer', 'exists:procurement_cases,id'],
            'budget_allocation_id' => ['sometimes', 'integer', 'exists:budget_allocations,id'],
            'budget_object_id' => ['sometimes', 'integer', 'exists:budget_objects,id'],
            'amount' => ['sometimes', 'numeric'],
        ]);

        return response()->json($this->service->update($budgetAllocationObject, $data));
    }

    public function destroy(BudgetAllocationObject $budgetAllocationObject)
    {
        $this->service->delete($budgetAllocationObject);

        return response()->json(null, 204);
    }
}
