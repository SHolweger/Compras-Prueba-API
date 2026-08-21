<?php

namespace App\Services;

use App\Models\CaseComment;
use Illuminate\Pagination\LengthAwarePaginator;

class CaseCommentService
{
    public function list(): LengthAwarePaginator
    {
        return CaseComment::query()->with('procurementCase')->paginate();
    }

    public function find(int $id): CaseComment
    {
        return CaseComment::query()->with('procurementCase')->findOrFail($id);
    }

    public function create(array $data): CaseComment
    {
        return CaseComment::query()->create($data);
    }

    public function update(CaseComment $caseComment, array $data): CaseComment
    {
        $caseComment->update($data);

        return $caseComment;
    }

    public function delete(CaseComment $caseComment): void
    {
        $caseComment->delete();
    }
}
