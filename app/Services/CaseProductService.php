<?php

namespace App\Services;

use App\Models\CaseProduct;
use Illuminate\Pagination\LengthAwarePaginator;

class CaseProductService
{
    public function list(): LengthAwarePaginator
    {
        return CaseProduct::query()->with(['procurementCase', 'supplyItem'])->paginate();
    }

    public function find(int $id): CaseProduct
    {
        return CaseProduct::query()->with(['procurementCase', 'supplyItem'])->findOrFail($id);
    }

    public function create(array $data): CaseProduct
    {
        return CaseProduct::query()->create($data);
    }

    public function update(CaseProduct $caseProduct, array $data): CaseProduct
    {
        $caseProduct->update($data);

        return $caseProduct;
    }

    public function delete(CaseProduct $caseProduct): void
    {
        $caseProduct->delete();
    }
}
