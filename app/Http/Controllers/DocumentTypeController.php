<?php

namespace App\Http\Controllers;

use App\Models\DocumentType;
use App\Services\DocumentTypeService;
use Illuminate\Http\Request;

class DocumentTypeController extends Controller
{
    public function __construct(protected DocumentTypeService $service) {}

    public function index()
    {
        return response()->json($this->service->list());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:45'],
            'is_free' => ['nullable', 'boolean'],
        ]);

        return response()->json($this->service->create($data), 201);
    }

    public function show(DocumentType $documentType)
    {
        return response()->json($this->service->find($documentType->id));
    }

    public function update(Request $request, DocumentType $documentType)
    {
        $data = $request->validate([
            'name' => ['sometimes', 'string', 'max:45'],
            'is_free' => ['nullable', 'boolean'],
        ]);

        return response()->json($this->service->update($documentType, $data));
    }

    public function destroy(DocumentType $documentType)
    {
        $this->service->delete($documentType);

        return response()->json(null, 204);
    }
}
