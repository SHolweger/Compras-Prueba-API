<?php

namespace App\Http\Controllers;

use App\Models\CaseProduct;
use App\Services\CaseProductService;
use Illuminate\Http\Request;

class CaseProductController extends Controller
{
    public function __construct(protected CaseProductService $service) {}

    public function index()
    {
        return response()->json($this->service->list());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'procurement_case_id' => ['required', 'integer', 'exists:procurement_cases,id'],
            'description' => ['required', 'string', 'max:300'],
            'quantity' => ['required', 'numeric'],
            'supply_item_id' => ['nullable', 'integer', 'exists:supply_items,id'],
            'presentation_code' => ['nullable', 'integer'],
        ]);

        return response()->json($this->service->create($data), 201);
    }

    public function show(CaseProduct $caseProduct)
    {
        return response()->json($this->service->find($caseProduct->id));
    }

    public function update(Request $request, CaseProduct $caseProduct)
    {
        $data = $request->validate([
            'procurement_case_id' => ['sometimes', 'integer', 'exists:procurement_cases,id'],
            'description' => ['sometimes', 'string', 'max:300'],
            'quantity' => ['sometimes', 'numeric'],
            'supply_item_id' => ['nullable', 'integer', 'exists:supply_items,id'],
            'presentation_code' => ['nullable', 'integer'],
        ]);

        return response()->json($this->service->update($caseProduct, $data));
    }

    public function destroy(CaseProduct $caseProduct)
    {
        $this->service->delete($caseProduct);

        return response()->json(null, 204);
    }
}
