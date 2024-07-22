<?php

namespace App\Http\Controllers;

use App\Traits\ResponseWithHttp;
use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    use ResponseWithHttp;
    public function editImage(Request $request)
    {
        if ($request->hasFile('profile_picture')) 
        {
            $validateImage = $request->validate([
                'profile_picture' => 'required|image|mimes:jpeg,png,jpg'
            ]);
            $image = $validateImage['profile_picture'];
            $path = $image->store('profile_pictures', 'public');
            
            // Add the profile_picture path to the credentials array
            $user = auth()->user();
            $user->profile_picture = $path;
            $user->save();
            $image_url = asset('storage/' . $user->profile_picture);

            return $this->success('image uploaded successfully', $image_url);
        }
        return $this->failure('please upload an image');
    }
}
