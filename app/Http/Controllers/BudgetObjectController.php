<?php

namespace App\Http\Controllers;

use App\Models\BudgetObject;
use App\Services\BudgetObjectService;
use Illuminate\Http\Request;

class BudgetObjectController extends Controller
{
    public function __construct(protected BudgetObjectService $service) {}

    public function index()
    {
        return response()->json($this->service->list());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['nullable', 'string', 'max:400'],
        ]);

        return response()->json($this->service->create($data), 201);
    }

    public function show(BudgetObject $budgetObject)
    {
        return response()->json($this->service->find($budgetObject->id));
    }

    public function update(Request $request, BudgetObject $budgetObject)
    {
        $data = $request->validate([
            'name' => ['nullable', 'string', 'max:400'],
        ]);

        return response()->json($this->service->update($budgetObject, $data));
    }

    public function destroy(BudgetObject $budgetObject)
    {
        $this->service->delete($budgetObject);

        return response()->json(null, 204);
    }
}
