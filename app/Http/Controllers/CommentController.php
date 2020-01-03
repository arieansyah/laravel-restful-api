<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\CommentUser;
use App\Model\Comment;
use App\Model\Post;
use Auth;
use Illuminate\Support\Facades\Redis;
use App\Http\Resources\Comment as CommentResourceCollection;
use Validator;

class CommentController extends Controller
{
    public function index()
    {
        Comment::query()->get();
    }


    public function store(Request $request)
    {
        $status = "error";
        $message = "";
        $data = null;
        $code = 200;

        $validator = Validator::make($request->all(), [
            'post_id' => 'required',
            'content' => 'required',
        ]);

        if (!$validator->fails()) {
            $comment = new Comment;
            $comment->author_id = Auth::user()->id;
            $comment->post_id = $request->post_id;
            $comment->content = $request->content;
            $comment->posted_at = now();
            if ($comment->save()) {
                $status = "success";
                $message = "Store Comment Success";
                $data = $comment->toArray();
                CommentUser::dispatch($comment);
            } else {
                $message = "Store Comment Failed";
            }
        }else {
            $errors = $validator->errors();
            $message = $errors;
        }

        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], $code);
    }

    public function show()
    {
        $comment = Post::with('comments')->get();
        return new CommentResourceCollection($comment);

    }
}
