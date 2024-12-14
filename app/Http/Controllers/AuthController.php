<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;



class AuthController extends Controller
{

    //register

    public function register(Request $request){
        // $validated = $request->validate([
        //     'name' => 'required|string|max: 50',
        //     'email' => 'required|string|email|max: 50|unique:users',
        //     'password' => 'required|string|min:6|confirmed',
        // ]);

        $validated = validator::make($request->all(),[
            'name' => 'required|string|max: 50',
            'email' => 'required|string|email|max: 50|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if($validated->fails()){
            return response()->json($validated->errors(), 403);
        }

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
    
            $token = $user->createToken('auth_token')->plainTextToken;
    

            return response()->json([
                'access_token' => $token,
                'user' => $user
            ], 200);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getmessage()], 403);
        }

       
    }


    //login

    public function login(Request $request): mixed{
        $validated = validator::make($request->all(),[
            'email' => 'required|string|email',
            'password' => 'required|string|min:6',
        ]);

        if($validated->fails()){
            return response()->json($validated->errors(), 403);
        }

        $credentials = ['email' => $request->email, 'password' => $request->password];

        try {
           if (!auth()->attemp($credentials)){
               return response()->json(['error' => 'Invalid credentials'], 403);
           }
           $user = User::where('email', $request->email)->firstOrfail();

           $token = $user->createToken('auth_token')->plainTextToken;

           return response()->json([
                'access_token' => $token,
                'user' => $user
           ], 200);


        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getmessage()], 403);
        }
    }

    //logout

    Public function logout(Request $request){
        $request->user()->token()->delete();

        return response()->json(['message' => 'user logged out successfully'], 200);
    }
}
