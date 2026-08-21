<?php

namespace App\Services;

use App\Models\Modality;
use Illuminate\Pagination\LengthAwarePaginator;

class ModalityService
{
    public function list(): LengthAwarePaginator
    {
        return Modality::query()->paginate();
    }

    public function find(int $id): Modality
    {
        return Modality::query()->findOrFail($id);
    }

    public function create(array $data): Modality
    {
        return Modality::query()->create($data);
    }

    public function update(Modality $modality, array $data): Modality
    {
        $modality->update($data);

        return $modality;
    }

    public function delete(Modality $modality): void
    {
        $modality->delete();
    }
}
