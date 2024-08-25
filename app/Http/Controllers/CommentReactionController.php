<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Traits\ResponseWithHttp;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\CommentResource;
use Illuminate\Contracts\Database\Eloquent\Builder;

class CommentReactionController extends Controller
{
    use ResponseWithHttp;
        /**
     * make a comment
     * 
     */
    public function createComment(Request $request, $post_id)
    {
        $user = Auth::user();
        $comment = $request->validate([
            'description'  => 'required|string'
        ]);
        try {
            $new_comment = $user->comments()->create([
                'post_id' => $post_id,
                'description' => $comment['description']
            ]);
            return $this->success('Comment created successfully', $new_comment);
        } catch (\Throwable $th) {
            return $this->failure('Unable to create new comment');
        }
    }
    /**
     * Get all comments related to a post
     */
    public function getPostComment($id)
    {
        $comment = Comment::whereHas('post', function (Builder $q) use($id)
        {
            $q->where('post_id', $id);
        })->get();
        if($comment->isNotEmpty())
        {

            return response()->json(['data' => CommentResource::collection($comment)]);
        }
        return response('No comments available for this post');
    }
}
