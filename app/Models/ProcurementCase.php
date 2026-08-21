<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProcurementCase extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'status_id',
        'unit_id',
        'user_id',
        'tray_id',
        'modality_id',
        'budget_object_id',
        'supplier_id',
        'form_number',
        'title',
        'description',
        'justification',
        'nog_number',
        'amount',
        'submitted_at',
        'completed_at',
        'check_number',
        'budget_line_reference',
        'is_suspended',
        'is_endorsed',
        'responsible_user_id',
    ];

    protected function casts(): array
    {
        return [
            'submitted_at' => 'datetime',
            'completed_at' => 'datetime',
            'is_suspended' => 'boolean',
            'is_endorsed' => 'boolean',
        ];
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    public function tray(): BelongsTo
    {
        return $this->belongsTo(Tray::class);
    }

    public function modality(): BelongsTo
    {
        return $this->belongsTo(Modality::class);
    }

    public function budgetObject(): BelongsTo
    {
        return $this->belongsTo(BudgetObject::class);
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function caseDocuments(): HasMany
    {
        return $this->hasMany(CaseDocument::class);
    }

    public function caseProducts(): HasMany
    {
        return $this->hasMany(CaseProduct::class);
    }

    public function caseComments(): HasMany
    {
        return $this->hasMany(CaseComment::class);
    }

    public function caseLogEntries(): HasMany
    {
        return $this->hasMany(CaseLogEntry::class);
    }

    public function caseTasks(): HasMany
    {
        return $this->hasMany(CaseTask::class);
    }

    public function budgetAllocations(): HasMany
    {
        return $this->hasMany(BudgetAllocation::class);
    }

    public function budgetAllocationObjects(): HasMany
    {
        return $this->hasMany(BudgetAllocationObject::class);
    }
}
