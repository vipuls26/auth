<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class AdminController extends Controller
{
    //
    public function dashboard()
    {
        // $id = Auth::user()->id;
        // $user = Auth::user();

        // $roleName = $user->roles->first()->name;
        // Log::info('showing dashboard to ' . $roleName .  'for id {id}', ['id' => $id, 'role' => $roleName]);

        return view('admin.dashboard');
    }
}
