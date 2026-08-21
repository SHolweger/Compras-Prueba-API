<?php

// use Illuminate\Http\Request;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\BudgetAllocationController;
use App\Http\Controllers\BudgetAllocationObjectController;
use App\Http\Controllers\BudgetObjectController;
use App\Http\Controllers\CaseCommentController;
use App\Http\Controllers\CaseDocumentController;
use App\Http\Controllers\CaseLogEntryController;
use App\Http\Controllers\CaseProductController;
use App\Http\Controllers\CaseTaskController;
use App\Http\Controllers\DocumentTypeController;
use App\Http\Controllers\ModalityController;
use App\Http\Controllers\ModalityDocumentController;
use App\Http\Controllers\ProcurementCaseController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SecurityProxyController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\SubprogramController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\SupplyItemController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TrayController;
use App\Http\Controllers\TrayUserController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UnitUserController;
use App\Http\Controllers\WorkController;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//    return $request->user();
// })->middleware('auth:sanctum');

Route::post('login', [SecurityProxyController::class, 'login']);

// Sin Middleware local
// Route::get('/funcion-interna', [SecurityProxyController::class, 'funcionInterna']);

// Con Middleware local
Route::middleware('jwt.security')->group(function () {
    Route::get('perfil', [SecurityProxyController::class, 'profile']);
    Route::get('menu-usuario/{systemId}/{userId}', [SecurityProxyController::class, 'menuByUser']);
    Route::get('roles-usuario/{userId}', [SecurityProxyController::class, 'rolesByUser']);
    Route::post('logout', [SecurityProxyController::class, 'logout']);

    // Jerarquía presupuestaria
    Route::apiResource('programs', ProgramController::class);
    Route::apiResource('subprograms', SubprogramController::class);
    Route::apiResource('projects', ProjectController::class);
    Route::apiResource('activities', ActivityController::class);
    Route::apiResource('works', WorkController::class);

    // Catálogos organizativos y de flujo
    Route::apiResource('units', UnitController::class);
    Route::apiResource('unit-users', UnitUserController::class);
    Route::apiResource('statuses', StatusController::class);
    Route::apiResource('modalities', ModalityController::class);
    Route::apiResource('trays', TrayController::class);
    Route::apiResource('tray-users', TrayUserController::class);
    Route::apiResource('tasks', TaskController::class);
    Route::apiResource('document-types', DocumentTypeController::class);
    Route::apiResource('modality-documents', ModalityDocumentController::class);
    Route::apiResource('budget-objects', BudgetObjectController::class);

    // Maestros
    Route::apiResource('suppliers', SupplierController::class);
    Route::apiResource('supply-items', SupplyItemController::class);

    // Transaccional (expedientes de compra)
    Route::apiResource('procurement-cases', ProcurementCaseController::class);
    Route::apiResource('case-documents', CaseDocumentController::class);
    Route::apiResource('case-products', CaseProductController::class);
    Route::apiResource('case-comments', CaseCommentController::class);
    Route::apiResource('case-log-entries', CaseLogEntryController::class);
    Route::apiResource('case-tasks', CaseTaskController::class);
    Route::apiResource('budget-allocations', BudgetAllocationController::class);
    Route::apiResource('budget-allocation-objects', BudgetAllocationObjectController::class);
});
