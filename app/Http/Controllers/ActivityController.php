<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Services\ActivityService;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function __construct(protected ActivityService $service) {}

    public function index()
    {
        return response()->json($this->service->list());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'project_id' => ['required', 'integer', 'exists:projects,id'],
            'code' => ['required', 'string', 'max:3'],
            'name' => ['required', 'string', 'max:200'],
        ]);

        return response()->json($this->service->create($data), 201);
    }

    public function show(Activity $activity)
    {
        return response()->json($this->service->find($activity->id));
    }

    public function update(Request $request, Activity $activity)
    {
        $data = $request->validate([
            'project_id' => ['sometimes', 'integer', 'exists:projects,id'],
            'code' => ['sometimes', 'string', 'max:3'],
            'name' => ['sometimes', 'string', 'max:200'],
        ]);

        return response()->json($this->service->update($activity, $data));
    }

    public function destroy(Activity $activity)
    {
        $this->service->delete($activity);

        return response()->json(null, 204);
    }
}
