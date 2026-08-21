<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class UnitUser extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'unit_id',
        'user_id',
        'can_create',
    ];

    protected function casts(): array
    {
        return [
            'can_create' => 'boolean',
        ];
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }
}
