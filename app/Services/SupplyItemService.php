<?php

namespace App\Services;

use App\Models\SupplyItem;
use Illuminate\Pagination\LengthAwarePaginator;

class SupplyItemService
{
    public function list(): LengthAwarePaginator
    {
        return SupplyItem::query()->paginate();
    }

    public function find(int $id): SupplyItem
    {
        return SupplyItem::query()->findOrFail($id);
    }

    public function create(array $data): SupplyItem
    {
        return SupplyItem::query()->create($data);
    }

    public function update(SupplyItem $supplyItem, array $data): SupplyItem
    {
        $supplyItem->update($data);

        return $supplyItem;
    }

    public function delete(SupplyItem $supplyItem): void
    {
        $supplyItem->delete();
    }

    // consulta.php accion 56 - presentaciones de un codigo de insumo
    public function byCode(int $code): \Illuminate\Database\Eloquent\Collection
    {
        return SupplyItem::query()
            ->where('code', $code)
            ->orderBy('presentation_code')
            ->get(['id', 'code', 'name', 'presentation', 'unit_of_measure', 'presentation_code']);
    }
}
