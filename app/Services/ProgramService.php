<?php

namespace App\Services;

use App\Models\Program;
use Illuminate\Pagination\LengthAwarePaginator;

class ProgramService
{
    public function list(): LengthAwarePaginator
    {
        return Program::query()->paginate();
    }

    public function find(int $id): Program
    {
        return Program::query()->findOrFail($id);
    }

    public function create(array $data): Program
    {
        return Program::query()->create($data);
    }

    public function update(Program $program, array $data): Program
    {
        $program->update($data);

        return $program;
    }

    public function delete(Program $program): void
    {
        $program->delete();
    }
}
