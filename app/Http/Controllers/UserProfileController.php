<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\ResponseWithHttp;
use Illuminate\Support\Facades\Storage;

class UserProfileController extends Controller
{
    use ResponseWithHttp;
    public function editImage(Request $request)
    {
        if ($request->hasFile('profile_picture')) 
        {
            $user = auth()->user();
            $validateImage = $request->validate([
                'profile_picture' => 'required|image|mimes:jpeg,png,jpg'
            ]);
            $image = $validateImage['profile_picture'];
            // Check if the user already has a profile picture
            if ($user->profile_picture) {
                // Delete the old image from storage
                Storage::disk('public')->delete($user->profile_picture);
            }
            $path = $image->store('profile_pictures', 'public');
            
            // Add the profile_picture path to the credentials array
            $user->profile_picture = $path;
            $user->save();
            $image_url = asset('storage/' . $user->profile_picture);

            return $this->success('image uploaded successfully', $image_url);
        }
        return $this->failure('please upload an image');
    }
}
