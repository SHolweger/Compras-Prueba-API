<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'subprogram_id',
        'code',
        'name',
    ];

    public function subprogram(): BelongsTo
    {
        return $this->belongsTo(Subprogram::class);
    }

    public function activities(): HasMany
    {
        return $this->hasMany(Activity::class);
    }
}
