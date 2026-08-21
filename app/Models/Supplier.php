<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'tax_id',
        'email',
        'phone',
        'contact_name',
        'address',
        'offerings',
    ];

    public function procurementCases(): HasMany
    {
        return $this->hasMany(ProcurementCase::class);
    }
}
