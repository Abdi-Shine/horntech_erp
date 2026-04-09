<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureSuperAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        $isHostOwner = $user && $user->role === 'admin' && $user->company_id == 1;

        if (!auth()->check() || ($user->role !== 'Super Admin' && !$isHostOwner)) {
            abort(403, 'Super Admin access required.');
        }

        return $next($request);
    }
}
