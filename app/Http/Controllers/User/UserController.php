<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function dashboard(Request $request)
    {
        $user_id = Auth::id();

        $query = Blog::where('user_id', $user_id);

        // category
        $category = Category::all();

        // user select category
        if ($request->filled('category')) {
            $categories = $request->input('category');
            $query->whereIn('category_id', (array)$categories);
        }

        // user search
        if ($request->has('search') && !empty($request->input('search'))) {
            $searchKeyWord = $request->input('search');
            $query->where('title', 'LIKE', '%' . $searchKeyWord . '%');
        }


        $blogs = $query->orderBy('blogs.id', 'desc')->paginate(8)->withQueryString();

        $total_blogs = Blog::where('user_id', Auth::id())->count();

        $user = Auth::user();
        if ($user) {
            $approved_blog = auth()->user()->blogs()->where('status', 'publish')->count();
            $pending_blog = auth()->user()->blogs()->where('status', 'pending')->count();
            $reviewd_blog = auth()->user()->blogs()->where('status', 'review')->count();
        }

        return view('user.dashboard', compact('blogs', 'category', 'total_blogs', 'pending_blog', 'reviewd_blog', 'approved_blog'));
    }   
}
