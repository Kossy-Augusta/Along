<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\CreatePostRequest;

class PostController extends Controller
{
    public function create(CreatePostRequest $request)
    {
        $credentials = $request->only('title', 'description', 'blog_image');
        $image = $credentials['blog_image'];
        $path = $image->store('blog_images', 'public');
        $credentials['blog_image'] = $path;
        $categoryName = $request->input('category');
        $categoryId = Category::where('name', $categoryName)->pluck('id')->first();
        if ($categoryId)
        {

            $post = auth()->user()->posts()->create($credentials);
            $post->category()->sync([$categoryId]);
            
            return response()->json(['message'=> 'Post created successfully']);
        }
        else
        {
            return response()->json(['message'=> 'Post not created, Category does not exist']);
        }
    }
}
