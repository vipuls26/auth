<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class EmailVerificationNotificationController extends Controller
{
 
    public function store(Request $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {

            $user = Auth::user();
            $role = $user->roles->first()->name;

            return redirect()->intended(url("/{$role}/dashboard"));
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('status', 'verification-link-sent');
    }
}
