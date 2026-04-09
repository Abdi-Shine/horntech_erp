<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        $user = Auth::user();
        $isHostOwner = $user && $user->role === 'admin' && $user->company_id == 1;

        if (!Auth::check() || ($user->role !== $role && !($role === 'Super Admin' && $isHostOwner))) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
