<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;

class AdminController extends Controller
{
    //
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function deleteTrash()
    {
        Artisan::call('app:delete-soft-delete-blog');
        return redirect()->back()->with('message', 'Trash cleared.');
    }
}
