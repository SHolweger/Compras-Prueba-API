<?php

namespace App\Http\Controllers;

use App\Models\CaseComment;
use App\Services\CaseCommentService;
use Illuminate\Http\Request;

class CaseCommentController extends Controller
{
    public function __construct(protected CaseCommentService $service) {}

    public function index()
    {
        return response()->json($this->service->list());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'procurement_case_id' => ['required', 'integer', 'exists:procurement_cases,id'],
            'user_id' => ['required', 'integer'],
            'comment' => ['required', 'string'],
            'commented_at' => ['required', 'date'],
        ]);

        return response()->json($this->service->create($data), 201);
    }

    public function show(CaseComment $caseComment)
    {
        return response()->json($this->service->find($caseComment->id));
    }

    public function update(Request $request, CaseComment $caseComment)
    {
        $data = $request->validate([
            'procurement_case_id' => ['sometimes', 'integer', 'exists:procurement_cases,id'],
            'user_id' => ['sometimes', 'integer'],
            'comment' => ['sometimes', 'string'],
            'commented_at' => ['sometimes', 'date'],
        ]);

        return response()->json($this->service->update($caseComment, $data));
    }

    public function destroy(CaseComment $caseComment)
    {
        $this->service->delete($caseComment);

        return response()->json(null, 204);
    }
}
