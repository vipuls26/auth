<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, $roles): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        $aaa=['dmin','super'];

        $user = Auth::user();
        $currentRole = $user->roles->first()->name;

        if ($currentRole !== $roles) {
            return redirect('/error-401');
        } else {
            return $next($request);
        }
    }
}
