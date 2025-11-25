<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EnsureUserHasRole
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(Request): (Response|RedirectResponse) $next
     * @param $roles
     * @return Response|RedirectResponse
     */
    public function handle(Request $request, Closure $next, $commaSeparatedRoles)
    {
        $passedRoles = explode(',', $commaSeparatedRoles);

        $roles = array_map(function ($role) use ($request) {
            // check if route model binding
            if (str_contains($role, '{') && str_contains($role, '}')) {
                $routeModelBindingArguments = explode(':', trim($role, '{}'));

                // check if route model binding specifies a column
                if (count($routeModelBindingArguments) === 2) {
                    return $request->route($routeModelBindingArguments[0])[$routeModelBindingArguments[1]];
                } else {
                    return $request->route($routeModelBindingArguments[0])['id'];
                }

            }

            return $role;
        }, $passedRoles);
        
        $user = $request->user();

        if (!$user || !$user->hasAnyRole($roles)) {
            abort(403);
        }

        return $next($request);
    }
}
