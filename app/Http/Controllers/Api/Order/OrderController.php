<?php

namespace App\Http\Controllers\Api\Order;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\OrderReuqest;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function get() {
        $order = auth()->user()->orders;
        return ApiResponse::successResponse(
            true,
            "Product Deleted Successfully",
            ["order"=>$order->load("order_item")],
            200
        );
    }

    public function set(OrderReuqest $request)  {
        $orders = Order::create([
            "user_id"=>auth()->user()->id,
            "name"=>$request->name,
            "address"=>$request->address,
            "phone"=>$request->phone,
            "total_price"=>$request->total_price,
        ]); 
        foreach ($request->items as $item) {
        
                 $orders->order_item()->create([
                    "product_id" =>$item['product_id'],
                    "price" =>$item['price'],
                    "quantity" =>$item['quantity'],
                 ]);
        }
        return ApiResponse::successResponse(
            true,
            "Product Deleted Successfully",
            ["order"=>$orders->load("order_item")],
            200
        );
        
    }   


    public function delete($id) {
        $order = Order::find($id);

        if(!$order)
            return ApiResponse::errorResponse(false,"Order not found" , ['Order Not Found'],401);
       

        $order->order_item()->delete();
        $order->delete();

        return ApiResponse::successResponse(
            true,
            "Order Deleted Successfully",
            null,
            200
        );
    }
}
