<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Traits\ResponseWithHttp;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\SingleCategoryPostResource;
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
}
