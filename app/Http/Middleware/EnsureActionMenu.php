<?php

namespace App\Http\Middleware;

use App\Models\RoleMenu;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class EnsureActionMenu
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $route = str_replace('.data', '.index', $request->route()->getName());
            $rm = RoleMenu::whereRoleId(Auth::user()->role_id)
                ->whereHas('menu', function($sql) use ($route) {
                    $sql->where('route_name', $route);
                })
                ->first();
            Session::put('ACTION_MENU_' . Auth::user()->id, json_encode($rm->action_menu ?? []));
        }
        return $next($request);
    }
}
