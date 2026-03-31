<?php

namespace App\Http\Controllers\Api\Blog;

use App\Http\Controllers\Controller;
use App\Http\Requests\Blog\BlogRequest;
use App\Http\Requests\Blog\UpdateRequest;
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

    // all blog
    public function allBlog(Request $request)
    {
        $blogs = Blog::with('image')->get();

        if (!$blogs) {
            return response()->json([
                'status' => 0,
                'message' => 'no blog found',
                'data' => $blogs
            ]);
        } else {
            return response()->json([
                'status' => 1,
                'message' => 'blog fetch successfully',
                'data' => $blogs
            ]);
        }
    }

    // for current user
    public function myBlog(Request $request)
    {
        $user_id = Auth::id();

        $blogs = Blog::with('image')->where('user_id', $user_id)->get();
        // dd($blogs);


        if (!$blogs) {
            return response()->json([
                'status' => 0,
                'message' => 'no blog found',
                'data' => $blogs
            ]);
        } else {
            return response()->json([
                'status' => 1,
                'message' => 'blog fetch for current user',
                'user_id' => $user_id,
                'data' => $blogs
            ]);
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
                'status' => 0,
                'message' => 'blog failed to upload',
            ]);
        } else {
            return response()->json([
                'status' => 1,
                'message' => 'blog uploaded successfully',
                'data' => $blog
            ]);
        }
    }

    // edit blog
    public function edit(Request $request, $id)
    {

        $blog_id = $id;
        $user_id = Auth::id();

        try {
            $blog = Blog::with('image')->where('id', $blog_id)->where('user_id', $user_id)->firstOrFail();
        } catch (Exception $e) {

            Log::warning($e);

            return response()->json([
                'status' => 0,
                'message' => 'this blog is not belongs to you'
            ]);
        }

        return response()->json([
            'status' => 1,
            'message' => 'edit blog working',
            'data' => $blog
        ]);
    }

    // update blog
    public function update(UpdateRequest $request, $id)
    {
        $blog_id = $id;
        $user_id = Auth::id();

        try {
            $blog = Blog::where('id', $blog_id)->where('user_id', $user_id)->firstOrFail();
        } catch (Exception $e) {
            Log::warning($e);
            return response()->json([
                'status' => 0,
                'message' => 'this is not your blog'
            ]);
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
            'status' => 1,
            'message' => 'this blog is your',
            'data' => ''
        ]);
    }

    // delete blog
    public function delete(Request $request, $id)
    {
        $blog_id = $id;
        $user_id = Auth::id();

        try {
            $blog = Blog::where('id', $blog_id)->where('user_id', $user_id)->firstOrFail();
        } catch (Exception $e) {
            Log::warning($e);
            return response()->json([
                'status' => 0,
                'message' => 'this is not your blog'
            ]);
        }

        $blog->delete();

        return response()->json([
            'status' => 1,
            'message' => 'blog is deleted successfully'
        ]);
    }

    // detail blog
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
                'status' => 0,
                'message' => 'this is not your blog'
            ]);
        }

        // send response if blog belong to user
        return response()->json([
            'status' => 1,
            'message' => 'detail api work',
            'data' => $blog
            ]);

    }
}
