<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Unit extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    // SCOPE para filtrar las unidades activas
    #[Scope]
    protected function active(Builder $query): void
    {
        $query->where('is_active', true);
    }

    // SCOPE para filtrar las unidades por el usuario propietario
    #[Scope]
    protected function forUser(Builder $query, int $userId): void
    {
        $query->whereHas('unitUsers', fn(Builder $q) => $q->where('user_id', $userId));
    }

    // Relaciones
    public function unitUsers(): HasMany
    {
        return $this->hasMany(UnitUser::class);
    }

    public function procurementCases(): HasMany
    {
        return $this->hasMany(ProcurementCase::class);
    }
}
