<?php

namespace App\Services;

use App\Models\Subprogram;
use Illuminate\Pagination\LengthAwarePaginator;

class SubprogramService
{
    public function list(): LengthAwarePaginator
    {
        return Subprogram::query()->with('program')->paginate();
    }

    public function find(int $id): Subprogram
    {
        return Subprogram::query()->with('program')->findOrFail($id);
    }

    public function create(array $data): Subprogram
    {
        return Subprogram::query()->create($data);
    }

    public function update(Subprogram $subprogram, array $data): Subprogram
    {
        $subprogram->update($data);

        return $subprogram;
    }

    public function delete(Subprogram $subprogram): void
    {
        $subprogram->delete();
    }
}
