<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class Cors
{
    public function handle($request, Closure $next)
    {
        // Si es preflight OPTIONS
        if ($request->isMethod('OPTIONS')) {
            return response('', 200, $this->corsHeaders());
        }

        $response = $next($request);

        // Añadir headers CORS a la respuesta
        foreach ($this->corsHeaders() as $key => $value) {
            $response->headers->set($key, $value);
        }

        return $response;
    }

    protected function corsHeaders(): array
    {
        return [
            'Access-Control-Allow-Origin' => '*',
            'Access-Control-Allow-Methods' => 'GET, POST, PUT, PATCH, DELETE, OPTIONS',
            'Access-Control-Allow-Headers' => 'Content-Type, Authorization, X-Requested-With, Accept, Origin',
            'Access-Control-Allow-Credentials' => 'true',
            'Access-Control-Max-Age' => '86400',
        ];
    }
}
