<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterFormRequest;
use App\Traits\ResponseWithHttp;

class UserAuthcontroller extends Controller
{
    use ResponseWithHttp;
    public function store(RegisterFormRequest $request)
    {
       
    $validatedData = $request->validated();
    $path = null;
    
    if ($request->hasFile('profile_picture')) 
    {
        $image = $request->file('profile_picture');
        $path = $image->store('profile_pictures', 'public');
        
        // Add the profile_picture path to the credentials array
        $validatedData['profile_picture'] = $path;
    }
        $validatedData['profile_picture'] = 'profile_pictures/blank-profile-picture-973460_1280.png';   
        $validatedData['password'] = Hash::make($request->password);
        $user = User::create($validatedData);
        return response()->json(['message' => 'Registered successfully'], Response::HTTP_CREATED);
        
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials))
        {
            $user = auth()->user();
            $remeber = $request->boolean('offer', false);
            //token exoires after 1 month if remeber me is checked else it expires after 1 hour
            $token = $user->createToken('api_token', ['*'], $remeber ? now()->addMonth(1): now()->addHours(1));
            $token = $token->plainTextToken;
            $url = asset('storage/' . $user->profile_picture);
            $name = $user->user_name;
            $email = $user->email;
            return $this->respondWithToken($token, ['image_url' => $url, 'user_name' => $name, 'email'=>$email]);
        }
        return $this->failure("invalid Credentials");
    }

    public function destroy()
    {
        auth()->user()->tokens()->delete();

        return response()->json(['message' => 'User successfully logged out']);
    }

    protected function respondWithToken($token, $data = [])
    {
        return response()->json([
            'token' => $token,
            'token_type' => 'bearer',
            'imge_url' => $data['image_url'],
            'user_name' => $data['user_name'],
            'email' => $data['email'],
            'status' => Response::HTTP_ACCEPTED
        ]);
    }
}
