<?php

namespace App\Http\Controllers;

use App\Http\Requests\Blog\BlogRequest;
use App\Models\Category;
use App\Models\Blog;
use App\Models\ImageUpload;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
// use Yajra\DataTables\DataTables;
use Yajra\DataTables\Facades\DataTables;


class BlogController extends Controller
{

    public function add()
    {
        $category = category::all('name');
        return view('blog.add', compact('category'));
    }

    // public function store(BlogRequest $request): RedirectResponse
    // {

    //     $request->validated();
    //     $file = $request->file('image');

    //     $user_id = Auth::user()->id;
    //     $category = category::where('name', $request->category)->first();

    //     $imageName = time() . '.' . $file->extension();

    //     $imagePath = $file->storeAs('Blogs', $imageName, 'public');

    //     $blog = Blog::create([
    //         'title' => $request->title,
    //         'content' => $request->content,
    //         'categories_id' => $category->id,
    //         'user_id' => $user_id,
    //     ]);

    //     ImageUpload::Create(
    //         [
    //             'name' => $imageName,
    //             'image_path' => $imagePath,
    //             'blog_id' => $blog->id,
    //             'user_id' => $user_id,
    //         ]
    //     );

    //     return redirect()->route('user.dashboard')->with('message', 'blog add successfully');
    // }

    public function store(BlogRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $file = $request->file('image');
        $user_id = Auth::user()->id;

        $category = category::where('name', $request->category)->first();
        // dd($category);


        $imageName = uniqid() . '.' . $file->extension();

        $imagePath = $file->storeAs('blogs', $imageName, 'public');

        $blog = Blog::create([
            'title' => $request->title,
            'content' => $request->content,
            'category_id' => $category->id,
            'user_id' => $user_id,
        ]);


        ImageUpload::create([
            'name' => $imageName,
            'image_path' => $imagePath,
            'blog_id' => $blog->id,
        ]);

        return redirect()->route('user.dashboard')->with('message', 'blog add successfully');
    }


    // for json format
    // public function show()
    // {
    //     return Blog::paginate();
    // }

    // pagination
    // public function show()
    // {
    //     $category = Category::all();
    //     $blogs = Blog::with('image')->paginate(4)->fragment('name');
    //     return view('blog.all', compact('blogs','category'));
    // }

    // simple pagination
    public function show(Request $request)
    {
        $query = Blog::query();

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

        $blogs = $query->orderBy('blogs.id', 'desc')->paginate(4);

        return view('blog.all', compact('blogs', 'category'));
    }



    // public function show()
    // {
    //     $blogs = Blog::with('image')->simplePaginate(2);
    //     return view('blog.all', compact('blogs'));
    // }
    // {{ $blogs->onEachSide(1)->links() }}

    // public function show()
    // {
    //     // $blogs = Blog::orderBy('id')::with('image')->cursorPaginate(2);

    //     // $blogs = Blog::orderBy('blogs.id')->with('image')->cursorPaginate(2);
    //     // $blogs = Blog::latest()->with('image')->cursorPaginate(4);

    //     $blogs = Blog::orderBy('blogs.id', 'desc')->with('image')->cursorPaginate(2);
    //     return view('blog.all', compact('blogs'));
    // }


    // display using yajra
    public function yajra(Request $request)
    {
        if ($request->ajax()) {

            // $blogs = Blog::with('user:id,name')->with('image')->with('category')->select('blogs.*');

            // $blogs = Blog::leftJoin('users', 'blogs.user_id', '=', 'users.id')
            //     ->with(['image', 'category'])
            //     ->select('blogs.*', 'users.name as user_name');

            $blogs = Blog::select([
                'blogs.id',
                'blogs.title',
                'blogs.content',
                'blogs.status',
                'blogs.created_at',
                'blogs.updated_at',
                'users.name as user_name',
                'categories.name as category_name',
            ])
                ->join('users', 'blogs.user_id', '=', 'users.id')
                ->join('categories', 'blogs.category_id', '=', 'categories.id');



            return DataTables::eloquent($blogs)
                ->addColumn('action', function ($row) {
                    return '<button>Edit</button>';
                })

                ->orderColumn('user.name', function ($query, $order) {
                    $query->orderBy('user.name', $order);
                })

                ->filterColumn('user_name', function ($query, $keyword) {
                    $query->where('users.name', 'like', '%' . $keyword . '%');
                })
                
                ->filterColumn('category_name', function ($query, $keyword) {
                    $query->where('categories.name', 'like', '%' . $keyword . '%');
                })


                ->rawColumns(['action'])
                ->make(true);
        }

        return view('blog.yajra-data');
    }




    public function detail($id)
    {
        $blogDetail = Blog::with('image')->findOrFail($id);
        return view('blog.detail', compact('blogDetail'));
    }
}
