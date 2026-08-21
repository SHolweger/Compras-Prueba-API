<?php

namespace App\Services;

use App\Models\Project;
use Illuminate\Pagination\LengthAwarePaginator;

class ProjectService
{
    public function list(): LengthAwarePaginator
    {
        return Project::query()->with('subprogram')->paginate();
    }

    public function find(int $id): Project
    {
        return Project::query()->with('subprogram')->findOrFail($id);
    }

    public function create(array $data): Project
    {
        return Project::query()->create($data);
    }

    public function update(Project $project, array $data): Project
    {
        $project->update($data);

        return $project;
    }

    public function delete(Project $project): void
    {
        $project->delete();
    }
}
