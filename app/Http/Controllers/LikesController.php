<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LikesController extends Controller
{
    public function likePost(Request $request){
        $validated = validator::make($request->all(),[
            'post_id' => 'required|integer',
        ]);

        if($validated->fails()){
            return response()->json($validated->errors(), 403);
        }

        try {
            $userLikePostBefore = like::where('user_id', auth()->user()->id)
            ->where('post_id', $request->post_id)->first();

            if($userLikePostBefore){
                return response()->json(['message' => 'you can not like a post twice'], 403);
                
            }else{
                $post = new Like();
                $post->post_id = $request->post_id;
                $post->user_id = auth()->user()->id;
                $post->save();
    
                return response()->json([
                    'message' => 'Post liked successesfully',
                ], 200);
            }

            

        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getmessage()], 403);
        }
}
}
