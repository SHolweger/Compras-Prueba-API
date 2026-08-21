<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Unit extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function unitUsers(): HasMany
    {
        return $this->hasMany(UnitUser::class);
    }

    public function procurementCases(): HasMany
    {
        return $this->hasMany(ProcurementCase::class);
    }
}
