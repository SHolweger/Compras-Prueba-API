<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class SupplyItem extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'code',
        'budget_object_code',
        'name',
        'specifications',
        'presentation',
        'unit_of_measure',
        'presentation_code',
    ];

    public function caseProducts(): HasMany
    {
        return $this->hasMany(CaseProduct::class);
    }
}
