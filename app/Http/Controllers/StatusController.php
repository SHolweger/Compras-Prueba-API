<?php

namespace App\Http\Controllers;

use App\Models\Status;
use App\Services\StatusService;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    public function __construct(protected StatusService $service) {}

    public function index()
    {
        return response()->json($this->service->list());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['nullable', 'string', 'max:45'],
            'color' => ['nullable', 'string', 'max:45'],
        ]);

        return response()->json($this->service->create($data), 201);
    }

    public function show(Status $status)
    {
        return response()->json($this->service->find($status->id));
    }

    public function update(Request $request, Status $status)
    {
        $data = $request->validate([
            'name' => ['nullable', 'string', 'max:45'],
            'color' => ['nullable', 'string', 'max:45'],
        ]);

        return response()->json($this->service->update($status, $data));
    }

    public function destroy(Status $status)
    {
        $this->service->delete($status);

        return response()->json(null, 204);
    }
}
