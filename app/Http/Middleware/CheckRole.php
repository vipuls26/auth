<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

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

        $user = Auth::user();

        if (!$user) {
            $user = User::find($user);
        }

        $currentRole = $user?->roles()->first()?->name ?? 'guest';
        
        if ($currentRole !== $roles) {
            return redirect('/error-401');
        } else {
            return $next($request);
        }
    }
}
