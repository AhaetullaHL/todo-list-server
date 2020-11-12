<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth as JWTAuth;

class AuthController extends Controller
{

    public $loginOnSignUp = true;

    public function login(Request $request)
    {
        $credentials = $request->only("email", "password");
        $token = null;

        if(!$token = JWTAuth::attempt($credentials)){
            return response(['message'=>'Unauthorized'], 401)->header('Content-Type', 'application/json');
        }
        return response(['token'=>$token], 200)->header('Content-Type', 'application/json');
    }

    public function register(Request $request)
    {
        $this->validate($request, [
           "name" => "required|string",
           "email" => "required|email",
           "password" => "required|string|min:6|max:64",
        ]);

        $user = User::create(["name" => $request->name, "email" => $request->email,"password" => bcrypt($request->password)]);

        if($this->loginOnSignUp){
            return $this->login($request);
        }
        return response(['user' => $user], 200)->header('Content-Type', 'application/json');
    }

    public function logout(Request $request)
    {
        $this->validate($request, [
           "token" => "required"
        ]);

        try{
            JWTAuth::invalidate($request->token);
            return response(['message' => 'Successfully logged out'], 200)->header('Content-Type', 'application/json');
        } catch (JWTException $exception){
            return response(['message' => 'Unauthorized'], 200)->header('Content-Type', 'application/json');
        }
    }
}
