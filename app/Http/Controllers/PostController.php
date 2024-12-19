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
       
    }


     //retrieve all posts

     public function getAllPosts(){
        try {
            $post = Post::all();
            return response()->json(['post' => $posts], 200);
       
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getmessage()], 403);
        }       
    }


    //get a post
    public function getPost($post_id){
        try {
            $post = Post::with('user', 'comment', 'likes')->where('id', $post_id)->first();
            return response()->json(['post' => $post], 200);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getmessage()], 403);
        }  
    }

     //delete
     public function deletePost(Request $request, $post_id){
        try {
           $post - Post::find($post_id);
           $post->delete();
           return response()->json(['message' => 'post deleted successfuly'], 200);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getmessage()], 403);
        } 
     }
}
