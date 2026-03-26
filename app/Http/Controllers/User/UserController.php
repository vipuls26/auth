<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;


class UserController extends Controller
{
    //
    public function dashboard()
    {
        // $id = Auth::user()->id;
        // $user = Auth::user();

        // $roleName = $user->roles->first()->name;
        // Log::alert('showing dashboard to ' . $roleName .  'for id {id}', ['id' => $id, 'role' => $roleName]);

        return view('user.dashboard');
    }




}
