<?php

namespace App\Http\Controllers\Api\Category;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    
    private function DeleteImage($image) : bool {
            if(File::exists($image)){
                if(File::delete($image))
                    return true;
            }
            return false;
    }

    public function index() {
        $category = Category::all();

        return ApiResponse::successResponse(
            true,"success",['category'=>$category],200
        );
    }
    public function children($id) {
        $category = Category::where("parent_id",$id)->get();

        return ApiResponse::successResponse(
            true,"success",['category'=>$category],200
        );
    }


    public function create(CategoryRequest $request) {
            $fullpath = '';
            if($request->hasFile('image')){
                $image =  $request->file('image')->store("category",'public');
                $fullpath = "storage/".$image;
            }

            $category = Category::create([
                "title"=>$request->title,
                "image"=>$fullpath,
                "parent_id"=>$request->perent
            ]);

            return ApiResponse::successResponse(
                true,
                "Add Category success",
                ["category"=>$category],
                200
            );
           
    
    }

    public function update(CategoryRequest $request , $id ) {
        $category = Category::where('id' , $id)->first();
        $fullpath = '';
        if($request->hasFile('image')){
            $image =  $request->file('image')->store("category",'public');
            $fullpath = "storage/".$image;


            if ($category->image)
                $this->DeleteImage($category->image);

        }

        $category->update([
            "title"=>$request->title,
            "image"=>$fullpath,
            "parent_id"=>$request->parent
        ]);

        return ApiResponse::successResponse(
            true,
            "Update Category success",
            ["category"=>$category, "path"=>$category->image],
            200
        );
    }
    
    public function delete($id) {
        
        $category = Category::find($id);

        if(!$category)
            return ApiResponse::errorResponse(false,"Can't Find Category",['Category not found'],401);

        if($category->parent_id != null)
            return ApiResponse::errorResponse(false,"Can't Delete Parent Category",["Can't Delete Parent Category"],401);

        $this->DeleteImage($category->image);
        $category->delete();
        return ApiResponse::successResponse(true, "Category deleted successfully", null, 200);

 
    }
}
