<?php

namespace App\Http\Controllers\Api\Product;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Models\ProductDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Mockery\Expectation;

class ProductController extends Controller
{

    private $paginateSize = 30;
    private function DeleteImages($images) {
        
        try{
            foreach($images as $image){
                if(File::exists($image))
                    File::delete($image);
            }
            return true;
         }
         catch(\ErrorException $er){
            return false;
         }
    }
    public function index($id=null)
    {
        try{
            $query = Product::orderBy('created_at', 'desc')
            ->with('details')
            ->with("category")
            ->with('admin:id,name');

        if (!is_null($id)) {
            $query->where("category_id", $id);
        }

        $products = $query->paginate($this->paginateSize);
        return ApiResponse::successResponse(
                true,
                "Get Product success",
                ['products'=>$products],
                200
            );
        }
        catch(\ErrorException $er){
           return ApiResponse::errorResponse(
                false,
                "Error",
                $er,
                404
            );
        }
    }
    public function create(ProductRequest $request) {

        try{
            $user = auth()->user();
            $images = array();
            $colors = array();
            $sizes = array();
            if($request->hasfile('images'))
            {
                foreach($request->file('images') as $image){
                    $path = $image->store('images','public');  
                    $path = "storage/".$path;
                    $images[] = $path;  
                }
            }

            if($request->get("colors"))
                foreach($request->get('colors') as $color)
                    $colors[] = $color;  
                
            
            if($request->get("sizes"))
                foreach($request->get('sizes') as $size)
                    $sizes[] = $size;  
                   
            
         
            if($sizes == [])
                $sizes = null;
            if($colors == [])
                $colors = null;
            
            $product = Product::create([
                "admin_id" => $user->id,
                "category_id" => $request->category_id,
                "title" => $request->title,
                "price" => $request->price,
                "discount" => $request->discount,
            
            ]);
            $productDetail = new ProductDetails([
                "description" => $request->description, 
                "quantity" => $request->quantity,
                "sizes" => $sizes,
                "colors" => $colors,
                "product_image" => $images,
            ]);
            
            $product->details()->save($productDetail);

            return ApiResponse::successResponse(
                true,
                "Upload Product Successfuly",
                ["product"=>$product->load('details')],
                200
            );
        
        }
        catch(\ErrorException $e){
            return ApiResponse::errorResponse(
                false,
                "Error",
                $e->getMessage(),
                404
            );
        }
        
        
    }

    public function update(ProductRequest $request,$id) {
        $product = Product::with("details")->find($id);

        if(!$product)
            return ApiResponse::errorResponse(false,"Product not found" , ['prodcut Not Found'],401);
        
            
              // Update product attributes
        $product->update([
            "category_id" => $request->category_id,
            "title" => $request->title,
            "price" => $request->price,
            "discount" => $request->discount,
        ]);

        // Update product details
        $productDetail = $product->details;
        if ($productDetail) {
            $productDetail->update([
                "description" => $request->description,
                "quantity" => $request->quantity,
                "sizes" => $request->get('sizes', []),
                "colors" => $request->get('colors', []),
            ]);

            // Update images if provided
            if ($request->hasfile('images')) {
                    $images = [];
                    foreach ($request->file('images') as $image) {
                        $path = $image->store('images','public');  
                        $path = "storage/".$path;
                        $images[] = $path;  
                    }

                    $productImage = $product->details->product_image;
                    $this->DeleteImages($productImage);
                    $productDetail->update([
                        "product_image" => $images,
                    ]);
            }

            return ApiResponse::successResponse(
                true,
                "Product Updated Successfully",
                ["product" => $product->load('details')],
                200
            );
        }
    

        return ApiResponse::successResponse(
            true,
            "Upload Product Successfuly",
            ["product"=>$product->load('details')],
            200
        );
    }

    public function delete($id) {
        $product = Product::find($id);

        if(!$product)
            return ApiResponse::errorResponse(false,"Product not found" , ['prodcut Not Found'],401);
       
        $productImage = $product->details->product_image;
        $this->DeleteImages($productImage);

        $product->details()->delete();
        $product->delete();

        return ApiResponse::successResponse(
            true,
            "Product Deleted Successfully",
            null,
            200
        );
    }
}

