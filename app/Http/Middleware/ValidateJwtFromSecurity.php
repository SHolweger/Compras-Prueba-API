<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ValidateJwtFromSecurity
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken();

        if (! $token) {
            return response()->json(['message' => 'Token requerido'], 401);
        }

        $response = Http::baseUrl(config('services.api-security.url'))
            ->acceptJson()
            ->withToken($token)
            ->get('/api/auth/me');

        if ($response->failed()) {
            return response()->json(['message' => 'Token inválido'], 401);
        }

        $request->attributes->set('api-security-user', $response->json('user'));

        return $next($request);
    }
}
