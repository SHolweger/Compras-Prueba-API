<?php

namespace App\Http\Controllers;

use App\Models\CaseDocument;
use App\Services\CaseDocumentService;
use Illuminate\Http\Request;

class CaseDocumentController extends Controller
{
    public function __construct(protected CaseDocumentService $service) {}

    public function index()
    {
        return response()->json($this->service->list());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'document_type_id' => ['required', 'integer', 'exists:document_types,id'],
            'procurement_case_id' => ['required', 'integer', 'exists:procurement_cases,id'],
            'user_id' => ['required', 'integer'],
            'uploaded_at' => ['required', 'date'],
            'file_path' => ['required', 'string', 'max:100'],
            'comment' => ['nullable', 'string'],
        ]);

        return response()->json($this->service->create($data), 201);
    }

    public function show(CaseDocument $caseDocument)
    {
        return response()->json($this->service->find($caseDocument->id));
    }

    public function update(Request $request, CaseDocument $caseDocument)
    {
        $data = $request->validate([
            'document_type_id' => ['sometimes', 'integer', 'exists:document_types,id'],
            'procurement_case_id' => ['sometimes', 'integer', 'exists:procurement_cases,id'],
            'user_id' => ['sometimes', 'integer'],
            'uploaded_at' => ['sometimes', 'date'],
            'file_path' => ['sometimes', 'string', 'max:100'],
            'comment' => ['nullable', 'string'],
        ]);

        return response()->json($this->service->update($caseDocument, $data));
    }

    public function destroy(CaseDocument $caseDocument)
    {
        $this->service->delete($caseDocument);

        return response()->json(null, 204);
    }
}
