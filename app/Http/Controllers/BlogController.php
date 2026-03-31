<?php

namespace App\Http\Controllers;

use App\Http\Requests\Blog\BlogRequest;
use App\Http\Requests\Blog\UpdateRequest;
use App\Models\Category;
use App\Models\Blog;
use App\Models\ImageUpload;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BlogController extends Controller
{

    public function add()
    {
        $category = category::all('name');
        return view('blog.add', compact('category'));
    }

    // add blog to db
    public function store(BlogRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $file = $request->file('image');
        $user_id = Auth::user()->id;

        $category = category::where('name', $request->category)->first();



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


    public function show(Request $request)
    {
        $query = Blog::query()->where('status', 'publish');

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

        return view('blog.all', compact('blogs', 'category'));
    }


    // for guest user
    public function guest(Request $request)
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

        $blogs = $query->orderBy('blogs.id', 'desc')->paginate(4)->withQueryString();

        return view('blog.guest', compact('blogs', 'category'));
    }


    // display using yajra
    public function yajra(Request $request)
    {
        if ($request->ajax()) {

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

                ->addColumn('status', function ($row) {

                    $options = '';
                    $statuses = ['pending', 'review', 'publish'];

                    foreach ($statuses as $status) {
                        $selected = ($row->status == $status) ? 'selected' : '';
                        $options .= '<option value="' . $status . '" ' . $selected . ' >' . $status . '</option>';
                    }

                    return '
                        <div class="inline-block relative">
                            <select class="status-dropdown cursor-pointer font-semibold
                                        bg-white border border-gray-200 text-gray-700
                                        hover:border-green-500 hover:bg-green-50
                                        px-6 py-2 pr-10 rounded-full text-sm shadow-sm
                                        transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-green-500/50"
                                    data-id="' . $row->id . '">
                                ' . $options . '
                            </select>
                        </div>';
                })

                ->editColumn('created_at', function ($row) {
                    return [
                        'date'   => $row->created_at->format('d/m/Y H:i:s')
                    ];
                })

                ->editColumn('updated_at', function ($row) {
                    return [
                        'date'   => $row->updated_at->format('d/m/Y H:i:s')
                    ];
                })

                ->filterColumn('user_name', function ($query, $keyword) {
                    $query->where('users.name', 'like', '%' . $keyword . '%');
                })

                ->filterColumn('category_name', function ($query, $keyword) {
                    $query->where('categories.name', 'like', '%' . $keyword . '%');
                })

                ->rawColumns(['status'])
                ->make(true);
        }

        return view('blog.yajra-data');
    }

    // update blog status by admin
    public function updateyajra(Request $request)
    {
        $id = $request->id;
        $status = $request->status;

        if (!empty($id) && !empty($status)) {
            Blog::updateOrCreate(
                ['id' => $id],
                ['status' => $status]
            );
            return response()->json(['success' => 'Status updated successfully!']);
        } else {
            return response()->json(['error' => 'error occur while updating']);
        }
    }


    // blog detail
    public function detail($id)
    {
        $blogDetail = Blog::with('image')->findOrFail($id);
        return view('blog.detail', compact('blogDetail'));
    }

    // blog of login user
    public function myBlog(Request $request)
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

        $blogs = $query->orderBy('blogs.id', 'desc')->paginate(4)->withQueryString();

        return view('user.dashboard', compact('blogs', 'category'));
    }

    // delete
    public function delete(Request $request, $id)
    {
        $user_id = Auth::id();
        $blog = Blog::where('id', $id)->where('user_id', $user_id)->first();

        if ($blog->user_id === $user_id) {
            $blog->delete();
            return redirect()->route('user.dashboard')->with('message', 'blog delete successfully');
        } else {
            return redirect()->route('user.dashboard')->with('message', 'this is not your blog');
        }
    }

    // edit
    public function edit(Blog $id)
    {
        $blog = $id;
        $category = Category::all('name');

        return view('blog.edit', compact('blog', 'category'));
    }

    public function updateBlog(UpdateRequest $request, $id)
    {
        // current user id
        $user_id = Auth::id();
        // validate input
        $validated = $request->validated();

        // find blog user id
        $blog = Blog::findOrFail($id)->where('user_id', $user_id);

        // fetch category id by name
        $category = category::where('name', $request->category)->first();

        // check if blog belong to user
        if ($blog === $user_id) {
            $blog->update([
                'title' => $request->title,
                'content' => $request->content,
                'category_id' => $category->id,
            ]);

            $file = $request->file('image');

            // check if file is upload
            if ($file) {
                // namimg of image upload
                $imageName = uniqid() . '.' . $file->extension();
                // store image in folder
                $imagePath = $file->storeAs('blogs', $imageName, 'public');
                // check if file exist or not
                $existing_image = ImageUpload::where('blog_id', $blog->id)->first();

                // delete old file if exist
                if ($existing_image) {
                    Storage::disk('public')->delete($existing_image->image_path);

                    $existing_image->update([
                        'name' => $imageName,
                        'image_path' => $imagePath
                    ]);
                } else {
                    ImageUpload::create([
                        'name' => $imageName,
                        'image_path' => $imagePath,
                        'blog_id' => $blog->id,
                    ]);
                }
            }

            return redirect()->route('user.dashboard')->with('message', 'blog update successfully');
        } else {
            return redirect()->route('user.dashboard')->with('message', 'this is not your blog');
        }
    }
}
