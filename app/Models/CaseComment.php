<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class CaseComment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'procurement_case_id',
        'user_id',
        'comment',
        'commented_at',
    ];

    protected function casts(): array
    {
        return [
            'commented_at' => 'datetime',
        ];
    }

    public function procurementCase(): BelongsTo
    {
        return $this->belongsTo(ProcurementCase::class);
    }
}
