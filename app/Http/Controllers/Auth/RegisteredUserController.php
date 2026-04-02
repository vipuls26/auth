<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use App\Models\Role;
use App\Notifications\RegisterNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    // display register page
    public function create(): View
    {
        $roles = Role::all('name');
        return view('auth.register' , compact('roles'));
    }

    // storing data into db
    public function store(RegisterRequest $request): RedirectResponse
    {
        // $request->validated();

        // fetch role from role table
        $role = Role::where('name', $request->role)->first();

        if (!$role) {
            return redirect()->route('register')->with('message', 'add role in db first');
        }

        // add user after validation pass
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password
        ]);


        // add role to save in db
        $user->roles()->attach($role);

        $user->notify(new RegisterNotification());


        return redirect()->route('login')->with('message', 'Registration successful');
    }

    public function checkEmail(Request $request)
    {
        $email = $request->email;
        $userExists = User::where('email', $email)->exists();

        // $msg = [ 'error' => 'this email already exist' ];
        if ($userExists) {
            return response()->json(false);
        } else {
            return response()->json(true);
        }
    }
}
