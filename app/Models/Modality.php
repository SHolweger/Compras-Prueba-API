<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Modality extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'min_amount',
        'max_amount',
    ];

    public function procurementCases(): HasMany
    {
        return $this->hasMany(ProcurementCase::class);
    }

    public function modalityDocuments(): HasMany
    {
        return $this->hasMany(ModalityDocument::class);
    }
}
