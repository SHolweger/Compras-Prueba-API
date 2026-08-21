<?php

namespace App\Services;

use App\Models\BudgetAllocationObject;
use Illuminate\Pagination\LengthAwarePaginator;

class BudgetAllocationObjectService
{
    public function list(): LengthAwarePaginator
    {
        return BudgetAllocationObject::query()->with(['procurementCase', 'budgetAllocation', 'budgetObject'])->paginate();
    }

    public function find(int $id): BudgetAllocationObject
    {
        return BudgetAllocationObject::query()->with(['procurementCase', 'budgetAllocation', 'budgetObject'])->findOrFail($id);
    }

    public function create(array $data): BudgetAllocationObject
    {
        return BudgetAllocationObject::query()->create($data);
    }

    public function update(BudgetAllocationObject $budgetAllocationObject, array $data): BudgetAllocationObject
    {
        $budgetAllocationObject->update($data);

        return $budgetAllocationObject;
    }

    public function delete(BudgetAllocationObject $budgetAllocationObject): void
    {
        $budgetAllocationObject->delete();
    }
}
