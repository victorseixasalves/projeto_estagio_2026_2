<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Impede que o site seja carregado dentro de um <iframe> em outro domínio (proteção contra clickjacking)
        $response->headers->set('X-Frame-Options', 'DENY');

        // Impede que o navegador tente "adivinhar" o tipo de um arquivo diferente do declarado
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // Controla quanta informação da URL de origem é enviada ao navegar para outro site
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        return $response;
    }
}