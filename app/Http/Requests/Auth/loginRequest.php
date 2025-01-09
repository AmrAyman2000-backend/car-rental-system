<?php

namespace App\Http\Requests\Auth;

use App\Http\Traits\apiResponse;
use App\Rules\EmailRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Validator;

class loginRequest extends FormRequest
{
    use apiResponse;
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "email" => ["required", "email",new EmailRule()],
            "password" => "required|string|min:8",
        ];
    }
    public function failedValidation(Validator|\Illuminate\Contracts\Validation\Validator $validator)
    {
        throw new HttpResponseException($this->apiResponse(400,"validation_errors",null,$validator->errors()));
    }
}
