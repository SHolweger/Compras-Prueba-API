<?php

namespace App\Http\Controllers;

use App\Models\Subprogram;
use App\Services\SubprogramService;
use Illuminate\Http\Request;

class SubprogramController extends Controller
{
    public function __construct(protected SubprogramService $service) {}

    public function index()
    {
        return response()->json($this->service->list());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'program_id' => ['required', 'integer', 'exists:programs,id'],
            'code' => ['required', 'string', 'max:2'],
            'name' => ['required', 'string', 'max:200'],
        ]);

        return response()->json($this->service->create($data), 201);
    }

    public function show(Subprogram $subprogram)
    {
        return response()->json($this->service->find($subprogram->id));
    }

    public function update(Request $request, Subprogram $subprogram)
    {
        $data = $request->validate([
            'program_id' => ['sometimes', 'integer', 'exists:programs,id'],
            'code' => ['sometimes', 'string', 'max:2'],
            'name' => ['sometimes', 'string', 'max:200'],
        ]);

        return response()->json($this->service->update($subprogram, $data));
    }

    public function destroy(Subprogram $subprogram)
    {
        $this->service->delete($subprogram);

        return response()->json(null, 204);
    }
}
