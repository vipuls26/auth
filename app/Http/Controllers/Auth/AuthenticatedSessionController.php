<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Notifications\LoginNotification;


class AuthenticatedSessionController extends Controller
{

    public function create(): View
    {
        return view('auth.login');
    }



    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->user()->notify(new LoginNotification());


        $request->session()->regenerate();

        $user = Auth::user();
        $roleName = $user->roles->first()->name;

        switch ($roleName) {
            case 'superadmin':
                return redirect()->route('superadmin.dashboard')->with('message', 'Welcome superadmin');
            case 'admin':
                return redirect()->route('admin.dashboard')->with('message', 'Welcome admin');
            case 'user':
                return redirect()->route('user.dashboard')->with('message', 'Welcome user');
            default:
                return redirect()->intended('/dashboard')->with('message', 'Welcome!');
        }
    }


    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
