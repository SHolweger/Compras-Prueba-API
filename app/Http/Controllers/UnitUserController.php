<?php

namespace App\Http\Controllers;

use App\Models\UnitUser;
use App\Services\UnitUserService;
use Illuminate\Http\Request;

class UnitUserController extends Controller
{
    public function __construct(protected UnitUserService $service) {}

    public function index()
    {
        return response()->json($this->service->list());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'unit_id' => ['required', 'integer', 'exists:units,id'],
            'user_id' => ['required', 'integer'],
            'can_create' => ['nullable', 'boolean'],
        ]);

        return response()->json($this->service->create($data), 201);
    }

    public function show(UnitUser $unitUser)
    {
        return response()->json($this->service->find($unitUser->id));
    }

    public function update(Request $request, UnitUser $unitUser)
    {
        $data = $request->validate([
            'unit_id' => ['sometimes', 'integer', 'exists:units,id'],
            'user_id' => ['sometimes', 'integer'],
            'can_create' => ['nullable', 'boolean'],
        ]);

        return response()->json($this->service->update($unitUser, $data));
    }

    public function destroy(UnitUser $unitUser)
    {
        $this->service->delete($unitUser);

        return response()->json(null, 204);
    }
}
