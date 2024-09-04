<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Reaction;
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

    public function createReaction(Request $request, $id)
    {
        $user = Auth::user();
        $reaction = $request->validate([
            'type'  => 'required|string'
        ]);
        try {
            $existing_reaction = Reaction::where('user_id', $user->id)
                                        ->where('post_id', $id)->first();
            if($existing_reaction)
            {
                if($existing_reaction->type == $reaction['type'])
                {
                    $existing_reaction->delete();
                    return response('Deleted existing reaction');
                }
                elseif($existing_reaction->type !== $reaction['type'])
                {
                    $existing_reaction->delete();
                }
            }
            $new_reaction = $user->reactions()->create([
                'post_id' => $id,
                'type' => $reaction['type']
            ]);
            return $this->success('reaction created successfully', $new_reaction);
        } catch (\Throwable $th) {
            return $this->failure('Unable to create a reaction');
        }
    }
}
