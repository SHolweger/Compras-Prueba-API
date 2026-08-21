<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class BudgetObject extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
    ];

    public function procurementCases(): HasMany
    {
        return $this->hasMany(ProcurementCase::class);
    }

    public function budgetAllocationObjects(): HasMany
    {
        return $this->hasMany(BudgetAllocationObject::class);
    }
}
