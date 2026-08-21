<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Services\ProgramService;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    public function __construct(protected ProgramService $service) {}

    public function index()
    {
        return response()->json($this->service->list());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'code' => ['required', 'string', 'max:2'],
            'name' => ['required', 'string', 'max:200'],
        ]);

        return response()->json($this->service->create($data), 201);
    }

    public function show(Program $program)
    {
        return response()->json($this->service->find($program->id));
    }

    public function update(Request $request, Program $program)
    {
        $data = $request->validate([
            'code' => ['sometimes', 'string', 'max:2'],
            'name' => ['sometimes', 'string', 'max:200'],
        ]);

        return response()->json($this->service->update($program, $data));
    }

    public function destroy(Program $program)
    {
        $this->service->delete($program);

        return response()->json(null, 204);
    }
}
