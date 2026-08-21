<?php

namespace App\Services;

use App\Models\Tray;
use Illuminate\Pagination\LengthAwarePaginator;

class TrayService
{
    public function list(): LengthAwarePaginator
    {
        return Tray::query()->paginate();
    }

    public function find(int $id): Tray
    {
        return Tray::query()->findOrFail($id);
    }

    public function create(array $data): Tray
    {
        return Tray::query()->create($data);
    }

    public function update(Tray $tray, array $data): Tray
    {
        $tray->update($data);

        return $tray;
    }

    public function delete(Tray $tray): void
    {
        $tray->delete();
    }
}
