<?php

namespace App\Services;

use App\Models\Status;
use Illuminate\Pagination\LengthAwarePaginator;

class StatusService
{
    public function list(): LengthAwarePaginator
    {
        return Status::query()->paginate();
    }

    public function find(int $id): Status
    {
        return Status::query()->findOrFail($id);
    }

    public function create(array $data): Status
    {
        return Status::query()->create($data);
    }

    public function update(Status $status, array $data): Status
    {
        $status->update($data);

        return $status;
    }

    public function delete(Status $status): void
    {
        $status->delete();
    }
}
