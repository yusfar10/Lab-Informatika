<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // kalau belum ada role yang diminta, lanjut saja
        if ($role === null) {
            return $next($request);
        }

        // pastikan user login
        if (!auth()->check()) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        // cek role user
        if (auth()->user()->role !== $role) {
            return response()->json([
                'message' => 'Forbidden: role tidak sesuai'
            ], 403);
        }
        return $next($request);
    }
}
