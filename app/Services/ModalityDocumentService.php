<?php

namespace App\Services;

use App\Models\ModalityDocument;
use Illuminate\Pagination\LengthAwarePaginator;

class ModalityDocumentService
{
    public function list(): LengthAwarePaginator
    {
        return ModalityDocument::query()->with(['modality', 'documentType', 'tray'])->paginate();
    }

    public function find(int $id): ModalityDocument
    {
        return ModalityDocument::query()->with(['modality', 'documentType', 'tray'])->findOrFail($id);
    }

    public function create(array $data): ModalityDocument
    {
        return ModalityDocument::query()->create($data);
    }

    public function update(ModalityDocument $modalityDocument, array $data): ModalityDocument
    {
        $modalityDocument->update($data);

        return $modalityDocument;
    }

    public function delete(ModalityDocument $modalityDocument): void
    {
        $modalityDocument->delete();
    }
}
