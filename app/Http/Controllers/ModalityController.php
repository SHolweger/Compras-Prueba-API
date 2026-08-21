<?php

namespace App\Http\Controllers;

use App\Models\Modality;
use App\Services\ModalityService;
use Illuminate\Http\Request;

class ModalityController extends Controller
{
    public function __construct(protected ModalityService $service) {}

    public function index()
    {
        return response()->json($this->service->list());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'min_amount' => ['required', 'numeric'],
            'max_amount' => ['required', 'numeric'],
        ]);

        return response()->json($this->service->create($data), 201);
    }

    public function show(Modality $modality)
    {
        return response()->json($this->service->find($modality->id));
    }

    public function update(Request $request, Modality $modality)
    {
        $data = $request->validate([
            'name' => ['sometimes', 'string', 'max:100'],
            'min_amount' => ['sometimes', 'numeric'],
            'max_amount' => ['sometimes', 'numeric'],
        ]);

        return response()->json($this->service->update($modality, $data));
    }

    public function destroy(Modality $modality)
    {
        $this->service->delete($modality);

        return response()->json(null, 204);
    }
}
