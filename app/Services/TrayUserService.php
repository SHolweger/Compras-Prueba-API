<?php

namespace App\Services;

use App\Models\TrayUser;
use Illuminate\Pagination\LengthAwarePaginator;

class TrayUserService
{
    public function list(): LengthAwarePaginator
    {
        return TrayUser::query()->with('tray')->paginate();
    }

    public function find(int $id): TrayUser
    {
        return TrayUser::query()->with('tray')->findOrFail($id);
    }

    public function create(array $data): TrayUser
    {
        return TrayUser::query()->create($data);
    }

    public function update(TrayUser $trayUser, array $data): TrayUser
    {
        $trayUser->update($data);

        return $trayUser;
    }

    public function delete(TrayUser $trayUser): void
    {
        $trayUser->delete();
    }
}
