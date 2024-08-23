<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Traits\ResponseWithHttp;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\SingleCategoryPostResource;
use App\Http\Resources\SinglePostResource;
use Illuminate\Contracts\Database\Eloquent\Builder;

class BlogController extends Controller
{ 
    use ResponseWithHttp;
    public function index()
    {
        $categories = Category::get();
        return $this->success('Success', CategoryResource::collection($categories));
        
    }
    public function singleCategory(Request $request)
    {
        $category_id= $request->input('category_id');
        $posts = Post::whereHas('category', function(Builder $q) use($category_id){
            $q->where('category_id', $category_id);
        })->get();

        return response()->json(['data' => SingleCategoryPostResource::collection($posts)]);
    }
    
    /**
     * Get details of a single post
     * @return response
     */

    public function show($id)
    {
        $post = Post::findOrFail($id);
        $data = [
        'title' => $post->title,
        'author' => $post->user->name,
        'post_date' => $post->updated_at,
        'description' => $post->description,
        ];
    return response()->json(['data' => $data]);
    }
    
    
}
