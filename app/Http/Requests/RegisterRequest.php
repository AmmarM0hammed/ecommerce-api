<?php

namespace App\Http\Requests;

use App\Rules\PhoneRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
class RegisterRequest extends FormRequest
{

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
            "phone"=>["required","numeric","unique:users,phone", new PhoneRule],
            "password"=>"required|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/|regex:/[@$!%*#?&]/",
            "confirm_password"=>"required|same:password",
        ];
    }

    public function attributes() {
        return [
            'name'=>"Name",
            'phone'=>"Phone",
            'Password'=>"Phone",
            'confirm_password'=>"Confirm Password",
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
