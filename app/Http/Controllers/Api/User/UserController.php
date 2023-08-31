<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\UserRequest;
use App\Models\UserDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    private function isLogin():bool{
        if(auth()->user())
            return true;
        return false;
    }

    public function getUser(){

        $user = auth()->user();

        if($this->isLogin()){
            return ApiResponse::successResponse(
                true,
                "User get success",
                ['user'=>$user->load('details')],
                200
            );
        }
        return ApiResponse::errorResponse(
            false,
            "There some error to get User",
            '',
            404
        );
    }

    public function update(UserRequest $request) {

        if($this->isLogin()){
            if(!Hash::check($request->password, auth()->user()->password))
                return ApiResponse::errorResponse(false,"The Password don't match",['password'=>"The Password don't match"],401);
           
            $user = Auth::user();
            $user->details()->update([
                "governorate" => $request->governorate,
                "region" => $request->region,
            ]);
            $user->name = $request->name;
            $user->save();

            return ApiResponse::successResponse(true,"Update Success",['user' => $user->load('details')],200
            );
        }
        return ApiResponse::errorResponse(false,"There are Error in Update",'',404);

    }

    public function changePassword(ChangePasswordRequest $request) {
       
        if(!Hash::check($request->old_password, auth()->user()->password))
            return ApiResponse::errorResponse(false,"The Old Password don't match",['password'=>"The Old Password don't match"],401);
        
            $user = auth()->user();
            
            $user->update([
                "password"=>Hash::make($request->new_password)
            ]);
            $user->save();

            return ApiResponse::successResponse(
                true,
                "Password Change is successfuly",
                "",
                200
            );
        
    }

}
