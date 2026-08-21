<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class CaseLogEntry extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'procurement_case_id',
        'tray_id',
        'user_id',
        'entered_at',
        'exited_at',
        'comment',
        'assigned_user_id',
    ];

    protected function casts(): array
    {
        return [
            'entered_at' => 'datetime',
            'exited_at' => 'datetime',
        ];
    }

    public function procurementCase(): BelongsTo
    {
        return $this->belongsTo(ProcurementCase::class);
    }

    public function tray(): BelongsTo
    {
        return $this->belongsTo(Tray::class);
    }
}
