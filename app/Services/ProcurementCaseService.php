<?php

namespace App\Services;

use App\Models\ProcurementCase;
use Illuminate\Pagination\LengthAwarePaginator;

class ProcurementCaseService
{
    protected array $with = ['status', 'unit', 'tray', 'modality', 'budgetObject', 'supplier'];

    public function list(): LengthAwarePaginator #GET
    {
        return ProcurementCase::query()->with($this->with)->paginate();
    }

    public function find(int $id): ProcurementCase #GET by ID
    {
        return ProcurementCase::query()->with($this->with)->findOrFail($id);
    }

    public function create(array $data): ProcurementCase #POST 
    {
        return ProcurementCase::query()->create($data);
    }

    public function update(ProcurementCase $procurementCase, array $data): ProcurementCase #PUT
    {
        $procurementCase->update($data);

        return $procurementCase;
    }

    public function delete(ProcurementCase $procurementCase): void #DELETE
    {
        $procurementCase->delete();
    }
}
