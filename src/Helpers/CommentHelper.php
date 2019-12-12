<?php

namespace FaithGen\SDK\Helpers;

use Illuminate\Http\Request;
use InnoFlash\LaraStart\Http\Helper;
use FaithGen\SDK\Http\Resources\Comment as CommentsResource;

class CommentHelper
{

    static function createComment($model, Request $request)
    {
        try {
            if (auth('web')->user())
                $comment = $model->comments()->create([
                    'comment' => $request->comment,
                    'creatable_id' => auth('web')->user()->id,
                    'creatable_type' => get_class(auth('web')->user()),
                ]);
            else
                $comment = $model->comments()->create([
                    'comment' => $request->comment,
                    'creatable_id' => auth()->user()->id,
                    'creatable_type' => get_class(auth()->user()),
                ]);
            return response()->json([
                'success' => true,
                'message' => 'Comment posted',
                'comment' => new CommentsResource($comment)
            ], 200);
        } catch (\Exception $e) {
            abort(500, $e->getMessage());
        }
    }

    static function getComments($model, Request $request)
    {
        $comments = $model->comments()->latest()->paginate(Helper::getLimit($request));
        CommentsResource::wrap('comments');
        return CommentsResource::collection($comments);
    }
}
