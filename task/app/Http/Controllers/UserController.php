<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Mail;
use App\Mail\UserWelcomeMail;

class UserController extends Controller
{
    public function register(Request $request){

        $request->validate([
            'name'=>'required|string|max:50',
            'email'=>'email|string|required|max:100|unique:users,email',
            'password'=>'required|string|min:8|confirmed'

        ]);
        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),

        ]);
        Mail::to($user->email)->send(new UserWelcomeMail($user));  
        return response()->json(
            [ 'message' => 'user registered successfully',
            "User" =>$user],201
            );
    }

    public function login(Request $request)
    {

        $request->validate([
            'email'=>'email|string|required',
            'password'=>'required|string|min:8'
        ]);

        if(!Auth::attempt($request->only('email','password'))){
            return response()->json(
                [
                    'message'=>'invalid email or password'
                ],401
            );

        };
        $user =User::where("email",$request->email)->FirstOrFail();
        $token=$user->createToken('auth_Token')->plainTextToken;
                return response()->json(
           [ 'message' => 'user login successfully',
           "User" =>$user,'Token'=>$token],200
        );

    }

    public function logout(Request $request){
        /** @var \Laravel\Sanctum\PersonalAccessToken $token */
        $token = $request->user()->currentAccessToken();
        $token->delete();
        return response()->json(
                [ 'message' => 'user logout successfully',
                ],200
        );
    }

    public function getProfile($id)
    {
        $profile = User::findOrFail($id)->profile;
        return response()->json($profile, 200);
    }
    public function getTasks($id)
    {
        $tasks = User::findOrFail($id)->tasks;
        return response()->json($tasks, 200);
    }

    public function getUser(){
        $user = Auth::user()->id;
        $userData=User::with('profile')->findOrFail($user);
        return new UserResource($userData);
    }
}
