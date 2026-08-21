<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Program extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'code',
        'name',
    ];

    public function subprograms(): HasMany
    {
        return $this->hasMany(Subprogram::class);
    }
}
