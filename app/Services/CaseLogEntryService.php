<?php

namespace App\Services;

use App\Models\CaseLogEntry;
use Illuminate\Pagination\LengthAwarePaginator;

class CaseLogEntryService
{
    public function list(): LengthAwarePaginator
    {
        return CaseLogEntry::query()->with(['procurementCase', 'tray'])->paginate();
    }

    public function find(int $id): CaseLogEntry
    {
        return CaseLogEntry::query()->with(['procurementCase', 'tray'])->findOrFail($id);
    }

    public function create(array $data): CaseLogEntry
    {
        return CaseLogEntry::query()->create($data);
    }

    public function update(CaseLogEntry $caseLogEntry, array $data): CaseLogEntry
    {
        $caseLogEntry->update($data);

        return $caseLogEntry;
    }

    public function delete(CaseLogEntry $caseLogEntry): void
    {
        $caseLogEntry->delete();
    }
}
