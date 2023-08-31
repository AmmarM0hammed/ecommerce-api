<?php

use App\Http\Controllers\Api\Order\OrderController;
use App\Http\Controllers\Api\User\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Admin\AdminController;


Route::group(['prefix' => "user" , "middleware"=>'auth:sanctum'], function () {
    Route::get("/", [UserController::class,'getUser']);
    Route::post("/update", [UserController::class,'update']);
    Route::post("/update/password", [UserController::class,'changePassword']);
    
    Route::get("/orders",[OrderController::class,'get']);
    Route::post("/orders",[OrderController::class,'set']);
    
});