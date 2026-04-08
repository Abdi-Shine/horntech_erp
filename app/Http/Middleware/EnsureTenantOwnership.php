<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class EnsureTenantOwnership
{
    /**
     * Verify that the first integer route parameter belongs to the authenticated user's company.
     *
     * Usage in routes: ->middleware('tenant.owns:customers')
     */
    public function handle(Request $request, Closure $next, string $table): Response
    {
        $user = auth()->user();

        if ($user && $user->company_id) {
            // Find the first route parameter that looks like a numeric ID
            $id = collect($request->route()->parameters())
                ->first(fn($v) => is_numeric($v));

            if ($id) {
                $exists = DB::table($table)
                    ->where('id', $id)
                    ->where('company_id', $user->company_id)
                    ->exists();

                if (!$exists) {
                    abort(403, 'Access denied: resource does not belong to your account.');
                }
            }
        }

        return $next($request);
    }
}
