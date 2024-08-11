<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'name' => 'required|string',
            'description' => 'sometimes|required|string'
        ]);
        $category = Category::create($validateData);
        return response()->json(['message' => 'Category created'], 201);
    }
}
