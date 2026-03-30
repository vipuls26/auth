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
        return view('admin.dashboard');
    }
}
