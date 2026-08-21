<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Status extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'color',
    ];

    public function procurementCases(): HasMany
    {
        return $this->hasMany(ProcurementCase::class);
    }
}
