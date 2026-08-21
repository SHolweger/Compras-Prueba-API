<?php

namespace App\Http\Controllers;

use App\Models\SupplyItem;
use App\Services\SupplyItemService;
use Illuminate\Http\Request;

class SupplyItemController extends Controller
{
    public function __construct(protected SupplyItemService $service) {}

    public function index()
    {
        return response()->json($this->service->list());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'code' => ['required', 'integer'],
            'budget_object_code' => ['required', 'integer'],
            'name' => ['required', 'string', 'max:100'],
            'specifications' => ['required', 'string'],
            'presentation' => ['nullable', 'string', 'max:100'],
            'unit_of_measure' => ['nullable', 'string', 'max:75'],
            'presentation_code' => ['nullable', 'integer'],
        ]);

        return response()->json($this->service->create($data), 201);
    }

    public function show(SupplyItem $supplyItem)
    {
        return response()->json($this->service->find($supplyItem->id));
    }

    public function update(Request $request, SupplyItem $supplyItem)
    {
        $data = $request->validate([
            'code' => ['sometimes', 'integer'],
            'budget_object_code' => ['sometimes', 'integer'],
            'name' => ['sometimes', 'string', 'max:100'],
            'specifications' => ['sometimes', 'string'],
            'presentation' => ['nullable', 'string', 'max:100'],
            'unit_of_measure' => ['nullable', 'string', 'max:75'],
            'presentation_code' => ['nullable', 'integer'],
        ]);

        return response()->json($this->service->update($supplyItem, $data));
    }

    public function destroy(SupplyItem $supplyItem)
    {
        $this->service->delete($supplyItem);

        return response()->json(null, 204);
    }
}
