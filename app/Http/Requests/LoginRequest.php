<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
class LoginRequest extends FormRequest
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
            if (Str::startsWith($this->request->get('phone'), '07')){
                $value = '964' . substr($this->request->get('phone'), 1);
                $this->request->set("phone",$value);
            }
            return [
                'phone' => 'required|numeric',
                'password' => 'required|max:255'
            ];
        }

        public function attributes() {
            return [
                'phone'=>"Phone Number",
                'password'=>"Password"
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
