<?php

namespace App\Services;

use App\Models\BudgetAllocation;
use Illuminate\Pagination\LengthAwarePaginator;

class BudgetAllocationService
{
    public function list(): LengthAwarePaginator
    {
        return BudgetAllocation::query()->with('procurementCase')->paginate();
    }

    public function find(int $id): BudgetAllocation
    {
        return BudgetAllocation::query()->with('procurementCase')->findOrFail($id);
    }

    public function create(array $data): BudgetAllocation
    {
        return BudgetAllocation::query()->create($data);
    }

    public function update(BudgetAllocation $budgetAllocation, array $data): BudgetAllocation
    {
        $budgetAllocation->update($data);

        return $budgetAllocation;
    }

    public function delete(BudgetAllocation $budgetAllocation): void
    {
        $budgetAllocation->delete();
    }
}
