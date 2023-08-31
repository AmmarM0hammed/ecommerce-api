<?php

namespace App\Http\Controllers;

use App\Http\Helpers\ApiResponse;
use App\Http\Requests\SettingRequest;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{

    private function isAdmin() : bool {
        if(auth()->user()->role == "admin")
            return true;
        return false;
    }
    public function get(){
        $setting =  Setting::first();
        return ApiResponse::successResponse(
            true,
            "Setting Success Getting",
            ["setting"=>$setting],
            200
        );
    }
    public function set(SettingRequest  $request){
        

        if($this->isAdmin()){
            $setting = Setting::first();
            if ($setting) {
                $setting->update($request->all());

                return ApiResponse::successResponse(
                    true,
                    "Update Seccuss",
                    ["setting"=>$setting],
                    200

                );
            } else {
                $setting = Setting::create($request->all());
                return ApiResponse::successResponse(
                    true,
                    "Create Successfuly",
                    ["setting"=>$setting],
                    200

                );
            }
        }

        return ApiResponse::errorResponse(
            false,
            "Access Denied",
            "User can't Edit Setting",
            401
        );
       
    }
}
