<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class EmailVerificationPromptController extends Controller
{

    public function __invoke(Request $request): RedirectResponse|View
    {

        $user = Auth::user();
        $role = $user->roles->first()->name;
        return $request->user()->hasVerifiedEmail()
            ? redirect()->intended(route("$role.dashboard", absolute: false))
            : view('auth.verify-email');
    }
}
