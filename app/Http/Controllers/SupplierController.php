<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Services\SupplierService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SupplierController extends Controller
{
    public function __construct(protected SupplierService $service) {}

    public function index()
    {
        return response()->json($this->service->list());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'tax_id' => ['required', 'string', 'max:45', 'unique:suppliers,tax_id'],
            'email' => ['nullable', 'string', 'max:45'],
            'phone' => ['nullable', 'string', 'max:45'],
            'contact_name' => ['nullable', 'string', 'max:45'],
            'address' => ['nullable', 'string', 'max:45'],
            'offerings' => ['nullable', 'string'],
        ]);

        return response()->json($this->service->create($data), 201);
    }

    public function show(Supplier $supplier)
    {
        return response()->json($this->service->find($supplier->id));
    }

    public function update(Request $request, Supplier $supplier)
    {
        $data = $request->validate([
            'name' => ['sometimes', 'string', 'max:100'],
            'tax_id' => ['sometimes', 'string', 'max:45', Rule::unique('suppliers', 'tax_id')->ignore($supplier->id)],
            'email' => ['nullable', 'string', 'max:45'],
            'phone' => ['nullable', 'string', 'max:45'],
            'contact_name' => ['nullable', 'string', 'max:45'],
            'address' => ['nullable', 'string', 'max:45'],
            'offerings' => ['nullable', 'string'],
        ]);

        return response()->json($this->service->update($supplier, $data));
    }

    public function destroy(Supplier $supplier)
    {
        $this->service->delete($supplier);

        return response()->json(null, 204);
    }
}
