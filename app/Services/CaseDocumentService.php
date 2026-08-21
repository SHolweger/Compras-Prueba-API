<?php

namespace App\Services;

use App\Models\CaseDocument;
use Illuminate\Pagination\LengthAwarePaginator;

class CaseDocumentService
{
    public function list(): LengthAwarePaginator
    {
        return CaseDocument::query()->with(['documentType', 'procurementCase'])->paginate();
    }

    public function find(int $id): CaseDocument
    {
        return CaseDocument::query()->with(['documentType', 'procurementCase'])->findOrFail($id);
    }

    public function create(array $data): CaseDocument
    {
        return CaseDocument::query()->create($data);
    }

    public function update(CaseDocument $caseDocument, array $data): CaseDocument
    {
        $caseDocument->update($data);

        return $caseDocument;
    }

    public function delete(CaseDocument $caseDocument): void
    {
        $caseDocument->delete();
    }
}
