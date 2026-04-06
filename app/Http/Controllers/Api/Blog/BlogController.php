<?php

namespace App\Http\Controllers\Api\Blog;

use App\Http\Controllers\Controller;
use App\Http\Requests\Blog\BlogRequest;
use App\Http\Requests\Blog\UpdateRequest;
use App\Http\Resources\BlogResource;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\Category;
use App\Models\ImageUpload;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;


class BlogController extends Controller
{

    // all blog for user
    public function allBlog()
    {
        // fetch only publish blog
        $blogs = Blog::with(['image', 'user', 'category'])->where('status', 'publish')->paginate(5);
        // $blogs = Blog::where('status', 'publish')->paginate(5);

        // check if blog are not empty
        if ($blogs->isEmpty()) {
            return response()->json([
                'status' => 404,
                'message' => 'no blog found',
            ], 404);
        } else {

            return response()->json([
                'status' => 200,
                'message' => 'successfully fetch blog',
                // 'data' => BlogResource::collection($blogs)
                'data' => $blogs
            ], 200);
        }
    }

    // for login user
    public function myBlog()
    {
        // login user user_id
        $user_id = Auth::id();

        // fetch blog which own by current user
        $blogs = Blog::with('image')->where('user_id', $user_id)->get();

        // check if user has blog or not
        if ($blogs->isEmpty()) {
            return response()->json([
                'status' => 200,
                'message' => 'you have not upload any blog yet',
            ], 200);
        } else {
            return response()->json([
                'status' => 200,
                'message' => 'successfully fetch blog',
                'data' => $blogs
            ], 200);
        }
    }

    // create blog
    public function create(BlogRequest $request)
    {
        // validation
        $validator = $request->all();

        // user id
        $user_id = Auth::id();

        // category id
        $category = Category::where('name', $request->category)->first();

        // image
        $file = $request->file('image');

        // unique image name
        $imageName = uniqid() . '.' . $file->extension();

        // store image
        $imagePath = $file->storeAs('blogs', $imageName, 'public');

        // store blog in db
        $blog = Blog::create([
            'title' => $request->title,
            'content' => $request->content,
            'category_id' => $category->id,
            'user_id' => $user_id,
        ]);

        // store image information in db
        ImageUpload::create([
            'name' => $imageName,
            'image_path' => $imagePath,
            'blog_id' => $blog->id,
        ]);

        if (!$blog) {
            return response()->json([
                'status' => 400,
                'message' => 'blog failed to upload',
            ], 400);
        } else {
            return response()->json([
                'status' => 200,
                'message' => 'blog uploaded successfully',
                'data' => $blog
            ], 201);
        }
    }

    // edit blog
    public function edit(Request $request, $id)
    {
        // blog id
        $blog_id = $id;

        // login user user_id
        $user_id = Auth::id();

        // check if blog belong to login user
        try {
            $blog = Blog::with('image')->where('id', $blog_id)->where('user_id', $user_id)->firstOrFail();
        } catch (Exception $e) {

            Log::warning($e);

            return response()->json([
                'status' => 401,
                'message' => 'you have no access to edit this blog'
            ], 401);
        }

        // pass message if blog were updated
        return response()->json([
            'status' => 200,
            'message' => 'edit blog fetch successfully',
            'data' => $blog
        ], 200);
    }

    // update blog
    public function update(UpdateRequest $request, $id)
    {
        // blog id
        $blog_id = $id;

        // login user user_id
        $user_id = Auth::id();

        // check if blog belong to login user
        try {
            $blog = Blog::where('id', $blog_id)->where('user_id', $user_id)->firstOrFail();
        } catch (Exception $e) {
            Log::warning($e);
            return response()->json([
                'status' => 401,
                'message' => 'you have no access to edit this blog'
            ], 401);
        }

        // fetch category id based on category name
        $category = category::where('name', $request->category)->first();

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

        return response()->json([
            'status' => 200,
            'message' => 'this blog is your',
            'data' => $blog
        ], 200);
    }

    // delete blog
    public function delete(Request $request, $id)
    {
        // blog id
        $blog_id = $id;

        // login user user_id
        $user_id = Auth::id();

        // fetch blog requested
        $blog = Blog::find($blog_id);

        // check if blog exist
        if (!$blog) {
            return response()->json([
                'status' => 404,
                'message' => 'requested blog does not exist'
            ], 404);
        }

        // check if user is owner of this blog
        if ($blog->user_id !== $user_id) {
            return response()->json([
                'status' => 403,
                'message' => 'you have no access to delete this blog'
            ], 403);
        }

        // delete blog
        try {
            $blog->delete();
            return response()->json([
                'status' => 302,
                'message' =>  'blog delete successfully'
            ], 302);
        } catch (Exception $e) {
            return response()->json([
                'status' => 500,
                'message' =>  'error occur while deleting blog'
            ], 500);
        }
    }


    // detail blog for login user
    public function detail(Request $request, $id)
    {
        // for current user
        $user_id = Auth::id();
        // blog id
        $blog_id = $id;

        // to check if blog belong to current user
        try {
            $blog = Blog::with('image')->where('id', $blog_id)->where('user_id', $user_id)->firstOrFail();
        } catch (Exception $e) {
            Log::warning($e);
            return response()->json([
                'status' => 401,
                'message' => 'this blog not belong to you'
            ]);
        }

        // send response if blog belong to user
        return response()->json([
            'status' => 200,
            'message' => 'blog detail fetch successfully',
            'data' => new BlogResource($blog)
        ]);
    }

    // for guest blog detail
    public function blogDetail(Request $request, $id)
    {
        $blog_id = $id;

        if (!is_numeric($blog_id)) {
            return response()->json([
                'status' => 404,
                'message' => 'id should be numeric'
            ]);
        }
        $blog = Blog::where('id', $blog_id)->first();

        if (!$blog) {
            return response()->json([
                'status' => 404,
                'message' => 'this blog does not exist'
            ], 404);
        }

        return response()->json([
            'status' => 200,
            'message' => 'blog detail fetch successfully',
            'data' => new BlogResource(Blog::find($id))
        ], 200);
    }

    // search
    public function search(Request $request)
    {
        $searchItem = $request->query('search');

        $blogs = Blog::query()->when($searchItem, function ($query, $searchItem) {
            $query->where('title', 'LIKE', '%' . $searchItem . '%');
        })->paginate(5);

        if ($blogs->isEmpty()) {
            return response()->json([
                'status' => 404,
                'message' => 'not result found'
            ], 404);
        }

        return response()->json([
            'status' => 200,
            'message' => 'search result',
            'data' => $blogs
        ], 200);
    }

    // total post
    public function postDetail()
    {
        $user_id = Auth::id();
        $totalBlog = Blog::where('user_id', $user_id)->count();
        $publishBlog = Blog::where('status','publish')->where('user_id',$user_id)->count();
        $pendingBlog = Blog::where('status','pending')->where('user_id',$user_id)->count();
        $reviewBlog = Blog::where('status','review')->where('user_id',$user_id)->count();

        return response()->json([
            'status' => 200,
            'message' => 'total post for login user',
            'totalPost' => $totalBlog,
            'pendingPost' => $pendingBlog,
            'publishPost' => $publishBlog,
            'reviewPost' => $reviewBlog
        ]);
    }
}
