<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

abstract class Controller
{
    // ID del usuario autenticado en la API, extraído del token JWTY
    protected function userId(Request $request): int
    {
        return (int) $request->attributes->get('api-security-user')['id'];
    }
}
