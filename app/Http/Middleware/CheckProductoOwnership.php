<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Producto;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckProductoOwnership
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $productoId = $request->route('producto') ?? $request->route('id');
        
        $producto = Producto::find($productoId);
    
        // Verificar si el usuario tiene una sesión activa y es un administrador
        if (session()->has('usuario') && session('usuario')->rol === 'admin') {
            return $next($request);
        }
    
        // Verificar si el producto existe y pertenece al usuario actual
        if ($producto && session()->has('usuario') && $producto->usuario_id == session('usuario')->id) {
            return $next($request);
        }
        
        return redirect()->route('usuarioPerfil')->with('error', 'No tienes permisos para realizar esta acción');
    }
    
}
