<?php

namespace App\Services;

use App\Models\Activity;
use Illuminate\Pagination\LengthAwarePaginator;

class ActivityService
{
    public function list(): LengthAwarePaginator
    {
        return Activity::query()->with('project')->paginate();
    }

    public function find(int $id): Activity
    {
        return Activity::query()->with('project')->findOrFail($id);
    }

    public function create(array $data): Activity
    {
        return Activity::query()->create($data);
    }

    public function update(Activity $activity, array $data): Activity
    {
        $activity->update($data);

        return $activity;
    }

    public function delete(Activity $activity): void
    {
        $activity->delete();
    }
}
