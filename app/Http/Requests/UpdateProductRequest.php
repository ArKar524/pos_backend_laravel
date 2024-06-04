<?php

namespace App\Http\Requests;

use Illuminate\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateProductRequest extends FormRequest
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
            'product_code' => '',
            'product_name' => 'required:string',
            'price' => 'required:decimal',
            'ProductCategoryId' => ''
        ];
    }

    public function faildedValidation(Validator $validator){
        throw new HttpResponseException(response()->json([
            'message' => 'Validation Errors',
            'data' => validator()->errors(),
            'status' => false
        ]));
    }
}
