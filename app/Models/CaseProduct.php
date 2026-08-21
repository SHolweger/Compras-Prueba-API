<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class CaseProduct extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'procurement_case_id',
        'description',
        'quantity',
        'supply_item_id',
        'presentation_code',
    ];

    public function procurementCase(): BelongsTo
    {
        return $this->belongsTo(ProcurementCase::class);
    }

    public function supplyItem(): BelongsTo
    {
        return $this->belongsTo(SupplyItem::class);
    }
}
