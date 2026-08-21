<?php

namespace App\Services;

use App\Models\Unit;
use Illuminate\Pagination\LengthAwarePaginator;

class UnitService
{
    public function list(): LengthAwarePaginator
    {
        return Unit::query()->paginate();
    }

    public function find(int $id): Unit
    {
        return Unit::query()->findOrFail($id);
    }

    public function create(array $data): Unit
    {
        return Unit::query()->create($data);
    }

    public function update(Unit $unit, array $data): Unit
    {
        $unit->update($data);

        return $unit;
    }

    public function delete(Unit $unit): void
    {
        $unit->delete();
    }
}
