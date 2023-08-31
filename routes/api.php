<?php

use App\Http\Controllers\Api\Category\CategoryController;
use App\Http\Controllers\Api\Product\ProductController;
use App\Http\Controllers\SettingController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AuthController;


// Public Routes
Route::controller(AuthController::class)->prefix("auth")->group(function(){
    Route::post("/login","login");
    Route::post("/register","register");
});

Route::get("/setting",[SettingController::class , "get"]);

// Category
Route::get("/category",[CategoryController::class , "index"]);
Route::get("/category/{id}",[CategoryController::class , "children"]);

//product
Route::get("/product",[ProductController::class , "index"]);
Route::get("/product/{id}",[ProductController::class , "index"]);


//Private Route
Route::middleware('auth:sanctum')->group(function(){
    Route::get("/logout",[AuthController::class,"logout"]);
});
