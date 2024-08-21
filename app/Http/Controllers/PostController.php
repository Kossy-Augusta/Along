<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use App\Http\Middleware\AccountTYpe;
use App\Http\Requests\UpdateRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CreatePostRequest;
use App\Http\Resources\UserPostsResource;

class PostController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $posts = new Post;
        $post = $posts->where('user_id', $user->id )->get();
        $count = $post->count();
        return response()->json(['post_count' => $count, 'posts' => UserPostsResource::collection($post),Response::HTTP_ACCEPTED]);

    }
    public function store(CreatePostRequest $request)
    {
        $credentials = $request->only('title', 'description', 'blog_image', "status", "category");
        $image = $credentials['blog_image'];
        $path = $image->store('blog_images', 'public');
        $credentials['blog_image'] = $path;
        $categoryName = $request->input('category');
        $categoryId = Category::where('name', $categoryName)->pluck('id')->first();
        if ($categoryId && $credentials['status'] == 'publish')
        {
            $user = auth()->user();
            $post = $user->posts()->create($credentials);
            $post->category()->sync([$categoryId]);
            
            return response()->json(['message'=> 'Post created successfully']);
        }
        else if($categoryId &&  $credentials['status'] == 'draft')
        {
            $user = auth()->user();
            $post = $user->drafts()->create($credentials);
            
            return response()->json(['message'=> 'Post successfully saved to drafts']);
        }
        else
        {
            return response()->json(['message'=> 'Post not created, Category does not exist']);
        }
    }
    public function show($id)
    {
        $post = Post::findOrFail($id);
        return response()->json(['product' => $post, Response:: HTTP_ACCEPTED]);
    }

    public function update($id, UpdateRequest $request)
    {

    }
}
