<?php

namespace App\Http\Requests;

use App\Enums\TaskStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rules\Enum;

class RequestTaskCreate extends FormRequest
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
            "title" => "required|string",          
            "description" => "nullable|min:5",    
            "status" => ['required', new Enum(TaskStatusEnum::class)],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = [
            'code'        => 400,
            'status'      => 'Bad Request',
            "message"     => "Error to create a task",
            'errors'      => $validator->errors(),
        ];
        throw new HttpResponseException(response()->json($response, 400));
    }

}
