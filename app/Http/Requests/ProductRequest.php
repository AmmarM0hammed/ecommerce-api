<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
class ProductRequest extends FormRequest
{
  
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "title"=>"required|max:50",
            "images" => "required",
            "images.*"=>'required|image|mimes:jpeg,png,jpg,gif',
            "category_id"=>'required|integer',
            "description"=>'required',
            "quantity"=>'required|integer',
            "sizes"=>'array',
            "colors"=>'array',
            "price"=>'required',
        ];
    }
    public function attributes() {
        return [
            'title'=>"Title",
            'image'=>"Image",
            'perent'=>"Perent",

        ];
    }
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => false,
            'errors' => $validator->errors(),
            "statecode"=>JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
            
        ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
    }
}
