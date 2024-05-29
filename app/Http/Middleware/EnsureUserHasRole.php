<?php

namespace App\Http\Middleware;

use Closure;

class EnsureUserHasRole
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  UserRole[]  $roles
     * @return mixed
     */
    public function handle($request, Closure $next, ...$roles)
    {
        $userRole = auth()->user()->role->value;

        if (in_array($userRole, $roles)) {
            return $next($request);
        }

        return redirect()->back()
            ->with('failed', 'Kamu tidak memilik izin untuk mengakses halaman tersebut.');
    }
}
