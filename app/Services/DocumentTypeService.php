<?php

namespace App\Services;

use App\Models\DocumentType;
use Illuminate\Pagination\LengthAwarePaginator;

class DocumentTypeService
{
    public function list(): LengthAwarePaginator
    {
        return DocumentType::query()->paginate();
    }

    public function find(int $id): DocumentType
    {
        return DocumentType::query()->findOrFail($id);
    }

    public function create(array $data): DocumentType
    {
        return DocumentType::query()->create($data);
    }

    public function update(DocumentType $documentType, array $data): DocumentType
    {
        $documentType->update($data);

        return $documentType;
    }

    public function delete(DocumentType $documentType): void
    {
        $documentType->delete();
    }
}
