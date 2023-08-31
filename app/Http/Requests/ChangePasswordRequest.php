<?php

namespace App\Http\Requests;


use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
class ChangePasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
    
        return [
            'old_password' => 'required|max:255',
            'new_password' => 'required|max:255',
            'confirm_password' => 'required|same:new_password|max:255',
        ];
    }

    public function attributes() {
        return [
            'old_password'=>"Old Password",
            'new_password'=>"New Password",
            'confirm_password'=>"Confirm Password"
        ];
    }
    protected function failedValidation(Validator $validator)
    {
      
        
        throw new HttpResponseException(response()->json([
            'status' => false,
            'errors' => $validator->errors(),
            "state-code"=>JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
            
        ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
    }
}