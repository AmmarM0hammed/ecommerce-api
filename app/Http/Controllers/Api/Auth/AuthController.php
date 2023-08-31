<?php

namespace App\Http\Controllers\Api\Auth;

use App\Events\UserDetailsEevent;
use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login(LoginRequest $request) {
        $form_data = $request->only(["phone","password"]);
        if(Auth::attempt($form_data)){
            $user = auth()->user();
            $token = $user->createToken($user->uid)->plainTextToken;
            $userWithDetails = auth()->user()->load('details');
            return ApiResponse::successResponse(true, "Login success",["token"=>$token,"user"=>$userWithDetails],200
            );
        }
        return ApiResponse::errorResponse(false,"","Error in Phone or Password",401);

    }
    public function register(RegisterRequest $request){
        
        $uid = Str::uuid();
        $user = User::create([
            "uid" => $uid,
            "name"=>$request->name,
            "phone"=>$request->phone,
            "password"=>Hash::make($request->password),
            
        ]);
        Auth::login($user);

        event(new UserDetailsEevent($user));
        $userWithDetails = auth()->user()->load('details');
        $token = $user->createToken($user->uid)->plainTextToken;

        return ApiResponse::successResponse(true, "User Created is successfuly",["token"=>$token,"user"=>$userWithDetails],200);
        
    }
    public function logout() {
        if(auth()->user()){
            auth()->user()->tokens()->delete();
            return ApiResponse::successResponse(true,"Logout success",'',200);
        }
    }
}
