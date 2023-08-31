<?php

use App\Http\Controllers\Api\Category\CategoryController;
use App\Http\Controllers\Api\Order\OrderController;
use App\Http\Controllers\Api\Product\ProductController;
use App\Http\Controllers\SettingController;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => "admin" , "middleware"=>['auth:sanctum',"admin"]], function () {

    Route::post("/setting",[SettingController::class,"set"]);    
    Route::post("/category/create" , [CategoryController::class , "create"]);
    Route::post("/category/update/{id}" , [CategoryController::class , "update"]);
    Route::post("/category/delete/{id}" , [CategoryController::class , "delete"]);

    Route::post("/product/create" , [ProductController::class , "create"]);
    Route::post("/product/update/{id}" , [ProductController::class , "update"]);
    Route::get("/product/delete/{id}" , [ProductController::class , "delete"]);
   
    Route::get("/order/delete/{id}" , [OrderController::class , "delete"]);


});