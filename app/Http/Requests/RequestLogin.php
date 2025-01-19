<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
class RequestLogin extends FormRequest
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
            'email'=> 'required|email',
            'password' => 'required:min:5'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = [
            'code'        => 400,
            'status'      => 'Bad Request',
            "message"     => "Error to login a user",
            'errors'      => $validator->errors(),
        ];
        throw new HttpResponseException(response()->json($response, 400));
    }
}
