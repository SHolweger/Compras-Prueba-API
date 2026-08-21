<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Services\TaskService;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function __construct(protected TaskService $service) {}

    public function index()
    {
        return response()->json($this->service->list());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['nullable', 'string', 'max:45'],
            'responsible_role' => ['nullable', 'string', 'max:45'],
            'days' => ['nullable', 'integer'],
            'is_business_days' => ['nullable', 'boolean'],
            'previous_task_id' => ['nullable', 'integer', 'exists:tasks,id'],
            'message_template' => ['nullable', 'string', 'max:100'],
        ]);

        return response()->json($this->service->create($data), 201);
    }

    public function show(Task $task)
    {
        return response()->json($this->service->find($task->id));
    }

    public function update(Request $request, Task $task)
    {
        $data = $request->validate([
            'name' => ['nullable', 'string', 'max:45'],
            'responsible_role' => ['nullable', 'string', 'max:45'],
            'days' => ['nullable', 'integer'],
            'is_business_days' => ['nullable', 'boolean'],
            'previous_task_id' => ['nullable', 'integer', 'exists:tasks,id'],
            'message_template' => ['nullable', 'string', 'max:100'],
        ]);

        return response()->json($this->service->update($task, $data));
    }

    public function destroy(Task $task)
    {
        $this->service->delete($task);

        return response()->json(null, 204);
    }
}
