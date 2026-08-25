<?php

namespace App\Models;

use App\Enums\CaseStatus;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
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

    // SCOPE para filtrar los casos de compra por el usuario propietario
    #[Scope]
    protected function ownedBy(Builder $query, int $userId): void
    {
        $query->where('user_id', $userId);
    }

    // SCOPE para filtrar los casos de compra por el estatus
    #[Scope]
    protected function withStatus(Builder $query, CaseStatus $status): void
    {
        $query->where('status_id', $status->value);
    }

    // SCOPE para filtrar los casos de compra por el término de búsqueda 
    #[Scope]
    protected function search(Builder $query, ?string $term): void
    {
        if ($term) {
            $query->where(function ($query) use ($term) {
                $query->Where('title', 'ilike', "%{$term}%")                          //filtrar por título
                    ->orWhere('description', 'ilike', "%{$term}%");                   //filtrar por descripción
                   // ->orWhere('justification', 'ilike', "%{$term}%")                //filtrar por justificación
                   // ->orWhere('nog_number', 'ilike', "%{$term}%")                   //filtrar por número de NOG
                   // ->orWhere('check_number', 'ilike', "%{$term}%")                 //filtrar por número de cheque
                   // ->orWhere('budget_line_reference', 'ilike', "%{$term}%");       //filtrar por referencia de línea presupuestaria
            });
        }
    }

    // Relaciones
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
