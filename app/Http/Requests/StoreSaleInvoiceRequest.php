<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSaleInvoiceRequest extends FormRequest
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
            'voucher_no' => "",
            'sale_invoice_date_time'=> '',
            'total_amount'=>'required',
            'discount'=> 'nullable',
            'tax'=> 'nullable',
            'payment_type'=> 'required',
            'payment_amount'=> 'required',
            'receive_amount'=> 'required',
            'change' => 'nullable'
        ];
    }
}
