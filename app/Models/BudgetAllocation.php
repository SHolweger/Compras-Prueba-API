<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class BudgetAllocation extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'procurement_case_id',
        'name',
        'program_code',
        'subprogram_code',
        'project_code',
        'activity_code',
        'work_code',
        'function_code',
        'object_code',
        'funding_source_code',
        'funding_org_code',
        'specific_fund_code',
    ];

    public function procurementCase(): BelongsTo
    {
        return $this->belongsTo(ProcurementCase::class);
    }

    public function budgetAllocationObjects(): HasMany
    {
        return $this->hasMany(BudgetAllocationObject::class);
    }
}
