<?php

namespace App\Http\Requests;


use App\Rules\PhoneRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class OrderReuqest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        if (Str::startsWith($this->request->get('phone'), '07')){
            $value = '964' . substr($this->request->get('phone'), 1);
            $this->request->set("phone",$value);
        }
        return [
            "name"=>"required|max:50",
            "quantity"=>"required|integer",
            "address" => "required",
            "phone"=>["required","numeric", new PhoneRule],
            "items"=>'required|array', 
        ];
    }
    public function attributes() {
        return [
            'name'=>"Name",
            'address'=>"Address",
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
