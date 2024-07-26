<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        
        // Verificar si el usuario tiene el rol de administrador
        if ($request->session()->has('usuario') && $request->session()->get('usuario')->rol === 'admin') {
            return $next($request);
        }

        // Si no es administrador, redirigir a una página de acceso no autorizado o a donde prefieras
        return redirect()->route('Inicio');
    }
}
