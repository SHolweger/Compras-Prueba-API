<?php

namespace App\Services;

use App\Models\Work;
use Illuminate\Pagination\LengthAwarePaginator;

class WorkService
{
    public function list(): LengthAwarePaginator
    {
        return Work::query()->with('activity')->paginate();
    }

    public function find(int $id): Work
    {
        return Work::query()->with('activity')->findOrFail($id);
    }

    public function create(array $data): Work
    {
        return Work::query()->create($data);
    }

    public function update(Work $work, array $data): Work
    {
        $work->update($data);

        return $work;
    }

    public function delete(Work $work): void
    {
        $work->delete();
    }
}
