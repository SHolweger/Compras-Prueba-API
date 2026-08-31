<?php

namespace App\Http\Controllers;

use App\Http\Requests\CaseProduct\StoreCaseProductRequest;
use App\Http\Requests\ProcurementCase\StoreProcurementCaseRequest;
use App\Http\Requests\ProcurementCase\UpdateProcurementCaseRequest;
use App\Models\CaseProduct;
use App\Models\ProcurementCase;
use App\Services\ProcurementCaseService;
use Illuminate\Http\Request;

class ProcurementCaseController extends Controller
{
    public function __construct(protected ProcurementCaseService $service) {}

    // consulta.php accion 2 - GET /api/procurement-cases?search=&per_page=
    public function index(Request $request)
    {
        return response()->json($this->service->drafts(
            $this->userId($request),
            $request->query('search'),
            (int) $request->query('per_page', 25),
        ));
    }

    // ingresa.php accion 1 - POST /api/procurement-cases
    public function store(StoreProcurementCaseRequest $request)
    {
        return response()->json(
            $this->service->createDraft($request->validated(), $this->userId($request)),
            201
        );
    }

    // GET /api/procurement-cases/{id}
    public function show(Request $request, ProcurementCase $procurementCase)
    {
        abort_unless($procurementCase->user_id === $this->userId($request), 404);

        return response()->json($this->service->find($procurementCase->id));
    }

    // actualiza.php accion 1 - PUT /api/procurement-cases/{id}
    public function update(UpdateProcurementCaseRequest $request, ProcurementCase $procurementCase)
    {
        return response()->json($this->service->updateDraft(
            $procurementCase,
            $request->validated(),
            $this->userId($request)
        ));
    }

    // borra.php accion 1 - DELETE /api/procurement-cases/{id}
    public function destroy(Request $request, ProcurementCase $procurementCase)
    {
        $this->service->deleteDraft($procurementCase, $this->userId($request));

        return response()->json(null, 204);
    }

    // ingresa.php accion 3 - POST /api/procurement-cases/{id}/submit
    public function submit(Request $request, ProcurementCase $procurementCase)
    {
        return response()->json(
            $this->service->submitToReview($procurementCase, $this->userId($request))
        );
    }

    // consulta.php accion 3 - GET /api/procurement-cases/{id}/products
    public function products(Request $request, ProcurementCase $procurementCase)
    {
        return response()->json(
            $this->service->products($procurementCase, $this->userId($request))
        );
    }

        // ingresa.php accion 2 - POST /api/procurement-cases/{id}/products
    public function addProduct(StoreCaseProductRequest $request, ProcurementCase $procurementCase)
    {
        return response()->json(
            $this->service->addProduct($procurementCase, $request->validated(), $this->userId($request)),
            201
        );
    }

    // borra.php accion 2 - DELETE /api/procurement-cases/{id}/products/{productId}
    public function removeProduct(Request $request, ProcurementCase $procurementCase, CaseProduct $caseProduct)
    {
        $this->service->removeProduct($procurementCase, $caseProduct, $this->userId($request));

        return response()->json(null, 204);
    }
}