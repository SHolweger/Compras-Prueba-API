<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Services\UnitService;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function __construct(protected UnitService $service) {}

    public function index()
    {
        return response()->json($this->service->list());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        return response()->json($this->service->create($data), 201);
    }

    public function show(Unit $unit)
    {
        return response()->json($this->service->find($unit->id));
    }

    public function update(Request $request, Unit $unit)
    {
        $data = $request->validate([
            'name' => ['sometimes', 'string', 'max:100'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        return response()->json($this->service->update($unit, $data));
    }

    public function destroy(Unit $unit)
    {
        $this->service->delete($unit);

        return response()->json(null, 204);
    }

    // GET /api/units/mine
    public function mine(Request $request)
    {
        return response()->json($this->service->listForUser($this->userId($request)));
    }
}
