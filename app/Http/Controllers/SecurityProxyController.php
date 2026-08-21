<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SecurityProxyController extends Controller
{
    public function profile(Request $request)
    {
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json([
                'message' => 'No se recibió bearer token',
            ], 401);
        }

        $authResponse = Http::baseUrl(config('services.api-security.url'))
            ->acceptJson()
            ->withToken($token)
            ->get('/api/auth/me');

        if ($authResponse->failed()) {
            return response()->json([
                'message' => 'No autorizado',
            ], 401);
        }

        // Datos de usuario sin Middleware
        // $user = $authResponse->json('user');

        // Datos de usuario con Middleware local
        $user = $request->attributes->get('api-security-user');

        return response()->json([
            'message' => 'Proceso ejecutado en API local',
            'user' => $user,
            'result' => [
                'status' => 'ok',
                'module' => 'orders',
            ],
        ]);
    }

    public function rolesByUser(Request $request, int $userId)
    {
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json([
                'message' => 'No se recibió bearer token',
            ], 401);
        }

        $response = Http::baseUrl(config('services.api-security.url'))
            ->acceptJson()
            ->withToken($token)
            ->get("/api/user-roles/{$userId}");

        if ($response->unauthorized()) {
            return response()->json([
                'message' => 'Token inválido o expirado',
            ], 401);
        }

        if ($response->failed()) {
            return response()->json([
                'message' => 'Error al consultar API de Seguridad',
                'error' => $response->json(),
            ], $response->status());
        }

        return response()->json([
            'source' => 'api-security',
            'data' => $response->json(),
        ]);
    }

    public function menuByUser(Request $request, int $systemId, int $userId)
    {
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json([
                'message' => 'No se recibió bearer token',
            ], 401);
        }

        $response = Http::baseUrl(config('services.api-security.url'))
            ->acceptJson()
            ->withToken($token)
            ->get("/api/menu/{$systemId}/{$userId}");

        if ($response->unauthorized()) {
            return response()->json([
                'message' => 'Token inválido o expirado',
            ], 401);
        }

        if ($response->failed()) {
            return response()->json([
                'message' => 'Error al consultar API de Seguridad',
                'error' => $response->json(),
            ], $response->status());
        }

        return response()->json([
            'source' => 'api-security',
            'data' => $response->json(),
        ]);
    }

    public function login(Request $request)
    {
        $response = Http::baseUrl(config('services.api-security.url'))
            ->acceptJson()
            ->post('/api/auth/login', $request->all());

        if ($response->unauthorized()) {
            return response()->json([
                'message' => 'Credenciales inválidas',
            ], 401);
        }

        if ($response->failed()) {
            return response()->json([
                'message' => 'Error al iniciar sesión en API de Seguridad',
                'error' => $response->json(),
            ], $response->status());
        }

        return response()->json([
            'source' => 'api-security',
            'data' => $response->json(),
        ]);
    }

    public function logout(Request $request)
    {
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json([
                'message' => 'No se recibió bearer token',
            ], 401);
        }

        $response = Http::baseUrl(config('services.api-security.url'))
            ->acceptJson()
            ->withToken($token)
            ->post('/api/auth/logout');

        if ($response->unauthorized()) {
            return response()->json([
                'message' => 'Token inválido o expirado',
            ], 401);
        }

        if ($response->failed()) {
            return response()->json([
                'message' => 'Error al cerrar sesión en API de Seguridad',
                'error' => $response->json(),
            ], $response->status());
        }

        return response()->json([
            'source' => 'api-security',
            'data' => $response->json(),
        ]);
    }
}
