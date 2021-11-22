<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;



class AuthControoler extends Controller
{
    public function register(UserRequest $request)
    {
        $data = $request->except(['password','password_confirmation']);
        $data['password'] = Hash::make($request->password);
        $user = User::create($data);

        $token = $user->createToken($data['name'].'Token')->plainTextToken;
        return response()->json([
            'msg'=>'Loged in Successfully',
            'status'=>201,
            'user'=>$user,
            'token'=>$token
        ],201);
    }

    function login(Request $request)
    {
        $user= User::where('email', $request->email)->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                return response([
                    'message' => ['These credentials do not match our records.']
                ], 404);
            }
        
            $token = $user->createToken($user->name . 'Token')->plainTextToken;
        
            $response = [
                'msg'=>'Loged in Successfully',
                'status'=>201,
                'user' => $user,
                'token' => $token
            ];
        
            return response($response, 201);
    }


    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();
        return response()->json([
            'msg'=>'Loged Out',
            'status'=>200
        ],200);
    }
}
