<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subprogram extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'program_id',
        'code',
        'name',
    ];

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }
}
