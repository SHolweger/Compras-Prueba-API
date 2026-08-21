<?php

namespace App\Http\Controllers;

use App\Models\Work;
use App\Services\WorkService;
use Illuminate\Http\Request;

class WorkController extends Controller
{
    public function __construct(protected WorkService $service) {}

    public function index()
    {
        return response()->json($this->service->list());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'activity_id' => ['required', 'integer', 'exists:activities,id'],
            'code' => ['required', 'string', 'max:3'],
            'name' => ['required', 'string', 'max:200'],
        ]);

        return response()->json($this->service->create($data), 201);
    }

    public function show(Work $work)
    {
        return response()->json($this->service->find($work->id));
    }

    public function update(Request $request, Work $work)
    {
        $data = $request->validate([
            'activity_id' => ['sometimes', 'integer', 'exists:activities,id'],
            'code' => ['sometimes', 'string', 'max:3'],
            'name' => ['sometimes', 'string', 'max:200'],
        ]);

        return response()->json($this->service->update($work, $data));
    }

    public function destroy(Work $work)
    {
        $this->service->delete($work);

        return response()->json(null, 204);
    }
}
