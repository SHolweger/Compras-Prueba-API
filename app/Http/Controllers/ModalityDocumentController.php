<?php

namespace App\Http\Controllers;

use App\Models\ModalityDocument;
use App\Services\ModalityDocumentService;
use Illuminate\Http\Request;

class ModalityDocumentController extends Controller
{
    public function __construct(protected ModalityDocumentService $service) {}

    public function index()
    {
        return response()->json($this->service->list());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'modality_id' => ['required', 'integer', 'exists:modalities,id'],
            'document_type_id' => ['required', 'integer', 'exists:document_types,id'],
            'tray_id' => ['required', 'integer', 'exists:trays,id'],
            'is_required' => ['nullable', 'boolean'],
        ]);

        return response()->json($this->service->create($data), 201);
    }

    public function show(ModalityDocument $modalityDocument)
    {
        return response()->json($this->service->find($modalityDocument->id));
    }

    public function update(Request $request, ModalityDocument $modalityDocument)
    {
        $data = $request->validate([
            'modality_id' => ['sometimes', 'integer', 'exists:modalities,id'],
            'document_type_id' => ['sometimes', 'integer', 'exists:document_types,id'],
            'tray_id' => ['sometimes', 'integer', 'exists:trays,id'],
            'is_required' => ['nullable', 'boolean'],
        ]);

        return response()->json($this->service->update($modalityDocument, $data));
    }

    public function destroy(ModalityDocument $modalityDocument)
    {
        $this->service->delete($modalityDocument);

        return response()->json(null, 204);
    }
}
