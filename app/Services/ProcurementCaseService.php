<?php

namespace App\Services;

use App\Enums\CaseStatus;
use App\Enums\TrayId;
use App\Models\CaseProduct;
use App\Models\ProcurementCase;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class ProcurementCaseService
{
    // Definir las relaciones que se cargarán automáticamente al consultar los casos de compra
    protected array $with = ['status', 'unit', 'tray', 'modality', 'budgetObject', 'supplier'];

    // Listar todos los casos de compra con paginación
    public function list(): LengthAwarePaginator
    {
        return ProcurementCase::query()->with($this->with)->paginate();
    }

    // Buscar casos de compra por el usuario propietario
    public function find(int $id): ProcurementCase 
    {
        return ProcurementCase::query()->with($this->with)->findOrFail($id);
    }

    // Buscar casos de compra por el usuario propietario
    public function create(array $data): ProcurementCase  
    {
        return ProcurementCase::query()->create($data);
    }

    // Actualizar un caso de compra existente
    public function update(ProcurementCase $procurementCase, array $data): ProcurementCase 
    {
        $procurementCase->update($data);

        return $procurementCase;
    }

    // Eliminar un caso de compra existente
    public function delete(ProcurementCase $procurementCase): void
    {
        $procurementCase->delete();
    }
   
    //NUEVAS FUNCIONES
    // consulta.php accion 2 - solicitudes pendientes de enviar, con el conteo de items
    public function drafts(int $userId, ?string $search = null, int $perPage = 25): LengthAwarePaginator
    {
        return ProcurementCase::query()
            ->with(['status:id,name,color', 'unit:id,name'])
            ->withCount('caseProducts')
            ->ownedBy($userId)
            ->withStatus(CaseStatus::Draft)
            ->whereYear('submitted_at', now()->year)
            ->search($search)
            ->orderByDesc('id')
            ->paginate($perPage);
    }

    // ingresa.php accion 1 - el estado y el autor los fija el servidor, nunca el cliente
    public function createDraft(array $data, int $userId): ProcurementCase
    {
        return ProcurementCase::query()->create([
            ...$data,
            'status_id' => CaseStatus::Draft->value,
            'user_id' => $userId,
            'submitted_at' => now(),
        ]);
    }

    // actualiza.php accion 1
    public function updateDraft(ProcurementCase $case, array $data, int $userId): ProcurementCase
    {
        $this->assertEditableDraft($case, $userId);
        $case->update($data);

        return $case;
    }

    // borra.php accion 1 - el legacy tambien rechaza si la solicitud tiene articulos
    public function deleteDraft(ProcurementCase $case, int $userId): void
    {
        $this->assertEditableDraft($case, $userId);
        abort_if($case->caseProducts()->exists(), 422, 'La solicitud incluye articulos.');

        $case->delete();
    }

    // ingresa.php accion 3 - arranca el flujo: bitacora + cambio de estado, en una transaccion
    public function submitToReview(ProcurementCase $case, int $userId): ProcurementCase
    {
        $this->assertEditableDraft($case, $userId);
        abort_if(
            $case->caseProducts()->doesntExist(),
            422,
            'La solicitud debe incluir al menos un articulo antes de enviarse.'
        );

        return DB::transaction(function () use ($case, $userId) {
            $case->caseLogEntries()->create([
                'tray_id' => TrayId::Review->value,
                'user_id' => $userId,
                'entered_at' => now(),
                'comment' => 'Revisar solicitud',
            ]);

            $case->update([
                'status_id' => CaseStatus::InProcess->value,
                'tray_id' => TrayId::Review->value,
                'submitted_at' => now(),
            ]);

            return $case->fresh();
        });
    }

    // consulta.php accion 3 - items de una solicitud
    public function products(ProcurementCase $case, int $userId): Collection
    {
        abort_unless($case->user_id === $userId, 404);

        return $case->caseProducts()->orderBy('id')->get();
    }

    // ingresa.php accion 2
    public function addProduct(ProcurementCase $case, array $data, int $userId): CaseProduct
    {
        $this->assertEditableDraft($case, $userId);

        return $case->caseProducts()->create($data);
    }

    // borra.php accion 2
    public function removeProduct(ProcurementCase $case, CaseProduct $product, int $userId): void
    {
        $this->assertEditableDraft($case, $userId);
        abort_unless($product->procurement_case_id === $case->id, 404);

        $product->delete();
    }

    // 404 si no es del usuario; 422 si ya salio de borrador
    protected function assertEditableDraft(ProcurementCase $case, int $userId): void
    {
        abort_unless($case->user_id === $userId, 404);
        abort_unless(
            $case->status_id === CaseStatus::Draft->value,
            422,
            'La solicitud ya fue enviada y no puede modificarse.'
        );
    }
}