<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfilePicture;
use App\Models\ImageUpload;
use App\Notifications\ProfileUpdateNotification;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Illuminate\Support\Facades\Storage;



class ImageUploadController extends Controller
{
    // public function upload(ProfilePicture $request): RedirectResponse
    // {

    //     if ($request->hasFile('profilePhoto')) {

    //         $userId = Auth::id();
    //         $file = $request->file('profilePhoto');

    //         $imageName = time() . '.' . $file->extension();

    //         $imagePath = $file->storeAs('profile', $imageName, 'public');

    //         $oldImage = ImageUpload::where('user_id', $userId)->first();

    //         if ($oldImage && $oldImage->image_path) {
    //             Storage::disk('public')->delete($oldImage->image_path);
    //         }

    //         ImageUpload::updateOrCreate(
    //             [
    //                 'user_id' => $userId,
    //                  'blog_id' => null,
    //             ],
    //             [
    //                 'name' => $imageName,
    //                 'image_path' => $imagePath
    //             ]
    //         );

    //         $request->user()->notify(new ProfileUpdateNotification());
    //     }

    //     return back()->with('message', 'Profile picture updated successfully');
    // }

    public function upload(ProfilePicture $request): RedirectResponse
    {
        if ($request->hasFile('profilePhoto')) {
            $userId = Auth::id();
            $file = $request->file('profilePhoto');
            // $imageName = time() . '.' . $file->extension();
            $imageName = uniqid() . '.' . $file->extension();
            $imagePath = $file->storeAs('profile', $imageName, 'public');


            $oldImage = ImageUpload::where('user_id', $userId)
                ->whereNull('blog_id')
                ->first();

            if ($oldImage && $oldImage->image_path) {
                Storage::disk('public')->delete($oldImage->image_path);
            }


            ImageUpload::updateOrCreate(
                [
                    'user_id' => $userId,
                    'blog_id' => null,
                ],
                [
                    'name' => $imageName,
                    'image_path' => $imagePath
                ]
            );

            $request->user()->notify(new ProfileUpdateNotification());
        }

        return back()->with('message', 'Profile picture updated successfully');
    }
}
