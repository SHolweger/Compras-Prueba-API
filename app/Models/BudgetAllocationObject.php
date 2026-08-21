<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class BudgetAllocationObject extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'procurement_case_id',
        'budget_allocation_id',
        'budget_object_id',
        'amount',
    ];

    public function procurementCase(): BelongsTo
    {
        return $this->belongsTo(ProcurementCase::class);
    }

    public function budgetAllocation(): BelongsTo
    {
        return $this->belongsTo(BudgetAllocation::class);
    }

    public function budgetObject(): BelongsTo
    {
        return $this->belongsTo(BudgetObject::class);
    }
}
