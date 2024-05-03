<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateStaffRequest extends FormRequest
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

                "staffCode" => "",
                "staffName" => "string",
                "dateOfBirth"=> "",
                "mobileNo"=> "required",
                "address" => "nullable",
                "gender"=> "in:Male,Female, Other",
                "position" => ""

            ];
    }

        public function failedValidation(Validator $validator) {
            throw new HttpResponseException(response()->json([
                'status' => false,
                'message' => 'Validation errors',
                'data' => $validator->errors()
            ]));
        }

}
