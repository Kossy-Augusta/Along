<?php

namespace App\Http\Controllers;

use App\Http\Resources\DraftIndexResource;
use App\Models\Draft;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DraftController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        try {
                $posts = Draft::where('user_id', $user->id)->get();
                if($posts->count() > 0)
                {
                    return response()->json(['post_drafts'=> DraftIndexResource::collection($posts)], Response::HTTP_ACCEPTED);
                }
                else
                {
                    return response()->json(['No posts saved to drafts'],Response::HTTP_ACCEPTED);
                }
        } catch (\Throwable $th) {
            return response()->json(["Cannot preform request"], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        
    }
}
