<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    public function postComment(Request $request){
        $validated = validator::make($request->all(),[
            'post_id' => 'required|integer',
            'comment' => 'required|string',
        ]);

        if($validated->fails()){
            return response()->json($validated->errors(), 403);
        }

        try {
            $post = new Comment();
            $post->post_id = $request->post_id;
            $post->comment = $request->comment;
            $post->user_id = auth()->user()->id;
            $post->save();

            return response()->json([
                'message' => 'Comment added successesfully',
            ], 200);

        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getmessage()], 403);
        }
}
}