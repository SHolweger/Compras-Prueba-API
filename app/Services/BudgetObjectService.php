<?php

namespace App\Services;

use App\Models\BudgetObject;
use Illuminate\Pagination\LengthAwarePaginator;

class BudgetObjectService
{
    public function list(): LengthAwarePaginator
    {
        return BudgetObject::query()->paginate();
    }

    public function find(int $id): BudgetObject
    {
        return BudgetObject::query()->findOrFail($id);
    }

    public function create(array $data): BudgetObject
    {
        return BudgetObject::query()->create($data);
    }

    public function update(BudgetObject $budgetObject, array $data): BudgetObject
    {
        $budgetObject->update($data);

        return $budgetObject;
    }

    public function delete(BudgetObject $budgetObject): void
    {
        $budgetObject->delete();
    }
}
