<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Role
{
    public function handle(Request $request, Closure $next, $role): Response
    {
        // Kalau rolenya gak sesuai sama pintu yang mau dimasuki, tendang!
        if ($request->user()->role !== $role) {
            abort(403, 'Akses Ditolak! Ini bukan ruangan Anda.');
        }

        return $next($request);
    }
}