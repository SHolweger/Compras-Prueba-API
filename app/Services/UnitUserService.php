<?php

namespace App\Services;

use App\Models\UnitUser;
use Illuminate\Pagination\LengthAwarePaginator;

class UnitUserService
{
    public function list(): LengthAwarePaginator
    {
        return UnitUser::query()->with('unit')->paginate();
    }

    public function find(int $id): UnitUser
    {
        return UnitUser::query()->with('unit')->findOrFail($id);
    }

    public function create(array $data): UnitUser
    {
        return UnitUser::query()->create($data);
    }

    public function update(UnitUser $unitUser, array $data): UnitUser
    {
        $unitUser->update($data);

        return $unitUser;
    }

    public function delete(UnitUser $unitUser): void
    {
        $unitUser->delete();
    }
}
