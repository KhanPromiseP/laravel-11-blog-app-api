<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function addNewPost(Request $request){
        $validated = validator::make($request->all(),[
            'title' => 'required|string',
            'content' => 'required|string',
            'user_id' => 'required|integer',
        ]);

        if($validated->fails()){
            return response()->json($validated->errors(), 403);
        }

        try {
            $post = new Post();
            $post->title = $request->title;
            $post->content = $request->content;
            $post->user_id = auth()->user()->id;
            $post->save();

            return response()->json([
                'message' => 'Post added successesfully',
            ], 200);

        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getmessage()], 403);
        }
    }

    //update post

    public function editPost(Request $request){
        $validated = validator::make($request->all(),[
            'title' => 'required|string',
            'content' => 'required|string',
            'post_id' => 'required|integer',
        ]);

        if($validated->fails()){
            return response()->json($validated->errors(), 403);
        }

        try {
            $post_data = Post::find($request->post_id);
            $updated_post = $post_data->update([
                'title' => $request->title,
                'content' => $request->content,
            ]);
            return response()->json([
                'message' => 'Post updated successesfully',
                'updated_post' => $updated_post,
            ], 200);

        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getmessage()], 403);
        }

        //delete
    }
}
