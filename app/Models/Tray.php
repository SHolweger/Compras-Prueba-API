<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tray extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'actor',
        'description',
        'icon',
        'color',
        'sort_order',
        'receive_label',
        'send_label',
        'route_path',
        'wording_template',
    ];

    public function procurementCases(): HasMany
    {
        return $this->hasMany(ProcurementCase::class);
    }

    public function trayUsers(): HasMany
    {
        return $this->hasMany(TrayUser::class);
    }

    public function modalityDocuments(): HasMany
    {
        return $this->hasMany(ModalityDocument::class);
    }

    public function caseLogEntries(): HasMany
    {
        return $this->hasMany(CaseLogEntry::class);
    }
}
