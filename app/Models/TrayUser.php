<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class TrayUser extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'tray_id',
        'user_id',
    ];

    public function tray(): BelongsTo
    {
        return $this->belongsTo(Tray::class);
    }
}
