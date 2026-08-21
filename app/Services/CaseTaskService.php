<?php

namespace App\Services;

use App\Models\CaseTask;
use Illuminate\Pagination\LengthAwarePaginator;

class CaseTaskService
{
    public function list(): LengthAwarePaginator
    {
        return CaseTask::query()->with(['procurementCase', 'task'])->paginate();
    }

    public function find(int $id): CaseTask
    {
        return CaseTask::query()->with(['procurementCase', 'task'])->findOrFail($id);
    }

    public function create(array $data): CaseTask
    {
        return CaseTask::query()->create($data);
    }

    public function update(CaseTask $caseTask, array $data): CaseTask
    {
        $caseTask->update($data);

        return $caseTask;
    }

    public function delete(CaseTask $caseTask): void
    {
        $caseTask->delete();
    }
}
