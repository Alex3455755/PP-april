<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Cors
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Принудительно добавляем CORS заголовки
        $response->headers->set('Access-Control-Allow-Origin', 'http://localhost:8080');
        $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
        $response->headers->set('Access-Control-Allow-Headers', '*');
        $response->headers->set('Access-Control-Allow-Credentials', 'false');
        $response->headers->set('Access-Control-Max-Age', '7200');

        // Обработка preflight запроса (OPTIONS)
        if ($request->isMethod('OPTIONS')) {
            return response()->json('OK', 200, $response->headers->all());
        }

        return $response;
    }
}