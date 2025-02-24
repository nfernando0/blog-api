<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator as ValidationValidator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Validator;

class UserRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'username' => ['required', 'unique:users,username', 'max:50'],
            'address' => ['max:100', 'nullable'],
            'phone' => ['nullable'],
            'email' => ['required', 'email:dns', 'unique:users,email'],
            'password' => ['required', 'min:3', 'max:10']
        ];
    }

    protected function failedValidation(ValidationValidator $validator)
    {
        throw new HttpResponseException(response([
            'errors' => $validator->getMessageBag()
        ], 400));
    }
}
