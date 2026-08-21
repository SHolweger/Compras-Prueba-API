<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Services\ProjectService;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function __construct(protected ProjectService $service) {}

    public function index()
    {
        return response()->json($this->service->list());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'subprogram_id' => ['required', 'integer', 'exists:subprograms,id'],
            'code' => ['required', 'string', 'max:3'],
            'name' => ['required', 'string', 'max:200'],
        ]);

        return response()->json($this->service->create($data), 201);
    }

    public function show(Project $project)
    {
        return response()->json($this->service->find($project->id));
    }

    public function update(Request $request, Project $project)
    {
        $data = $request->validate([
            'subprogram_id' => ['sometimes', 'integer', 'exists:subprograms,id'],
            'code' => ['sometimes', 'string', 'max:3'],
            'name' => ['sometimes', 'string', 'max:200'],
        ]);

        return response()->json($this->service->update($project, $data));
    }

    public function destroy(Project $project)
    {
        $this->service->delete($project);

        return response()->json(null, 204);
    }
}
