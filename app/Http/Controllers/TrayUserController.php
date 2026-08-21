<?php

namespace App\Http\Controllers;

use App\Models\TrayUser;
use App\Services\TrayUserService;
use Illuminate\Http\Request;

class TrayUserController extends Controller
{
    public function __construct(protected TrayUserService $service) {}

    public function index()
    {
        return response()->json($this->service->list());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'tray_id' => ['required', 'integer', 'exists:trays,id'],
            'user_id' => ['required', 'integer'],
        ]);

        return response()->json($this->service->create($data), 201);
    }

    public function show(TrayUser $trayUser)
    {
        return response()->json($this->service->find($trayUser->id));
    }

    public function update(Request $request, TrayUser $trayUser)
    {
        $data = $request->validate([
            'tray_id' => ['sometimes', 'integer', 'exists:trays,id'],
            'user_id' => ['sometimes', 'integer'],
        ]);

        return response()->json($this->service->update($trayUser, $data));
    }

    public function destroy(TrayUser $trayUser)
    {
        $this->service->delete($trayUser);

        return response()->json(null, 204);
    }
}
