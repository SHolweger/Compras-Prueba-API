<?php

namespace App\Http\Controllers;

use App\Models\Tray;
use App\Services\TrayService;
use Illuminate\Http\Request;

class TrayController extends Controller
{
    public function __construct(protected TrayService $service) {}

    public function index()
    {
        return response()->json($this->service->list());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:45'],
            'actor' => ['nullable', 'string', 'max:45'],
            'description' => ['required', 'string', 'max:300'],
            'icon' => ['required', 'string', 'max:45'],
            'color' => ['required', 'string', 'max:45'],
            'sort_order' => ['nullable', 'integer'],
            'receive_label' => ['nullable', 'string', 'max:45'],
            'send_label' => ['nullable', 'string', 'max:45'],
            'route_path' => ['nullable', 'string', 'max:45'],
            'wording_template' => ['nullable', 'string', 'max:100'],
        ]);

        return response()->json($this->service->create($data), 201);
    }

    public function show(Tray $tray)
    {
        return response()->json($this->service->find($tray->id));
    }

    public function update(Request $request, Tray $tray)
    {
        $data = $request->validate([
            'name' => ['sometimes', 'string', 'max:45'],
            'actor' => ['nullable', 'string', 'max:45'],
            'description' => ['sometimes', 'string', 'max:300'],
            'icon' => ['sometimes', 'string', 'max:45'],
            'color' => ['sometimes', 'string', 'max:45'],
            'sort_order' => ['nullable', 'integer'],
            'receive_label' => ['nullable', 'string', 'max:45'],
            'send_label' => ['nullable', 'string', 'max:45'],
            'route_path' => ['nullable', 'string', 'max:45'],
            'wording_template' => ['nullable', 'string', 'max:100'],
        ]);

        return response()->json($this->service->update($tray, $data));
    }

    public function destroy(Tray $tray)
    {
        $this->service->delete($tray);

        return response()->json(null, 204);
    }
}
