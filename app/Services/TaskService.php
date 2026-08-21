<?php

namespace App\Services;

use App\Models\Task;
use Illuminate\Pagination\LengthAwarePaginator;

class TaskService
{
    public function list(): LengthAwarePaginator
    {
        return Task::query()->with('previousTask')->paginate();
    }

    public function find(int $id): Task
    {
        return Task::query()->with('previousTask')->findOrFail($id);
    }

    public function create(array $data): Task
    {
        return Task::query()->create($data);
    }

    public function update(Task $task, array $data): Task
    {
        $task->update($data);

        return $task;
    }

    public function delete(Task $task): void
    {
        $task->delete();
    }
}
