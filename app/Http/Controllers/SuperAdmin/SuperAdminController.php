<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Jobs\SendData;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\AdminMail;

class SuperAdminController extends Controller
{
    //
    public function dashboard()
    {
        return view('superadmin.dashboard');
    }

    public function alluser()
    {
        $users = User::with('roles')->with('image')->get();
        return view('superadmin.all', compact('users'));
    }

    //user audit
    public function history(User $id)
    {
        // dd($id);
        $user = User::with('audit')->get();

        dd($user);
        return view('superadmin.history', compact('user'));
    }

    public function sendData()
    {

        $data = User::with('roles')->with('image')->get();

        Mail::to('example@gmail.com')
            ->queue((new AdminMail($data))->onQueue('high'));

        return view('superadmin.sendData', compact('data'));
    }
}
