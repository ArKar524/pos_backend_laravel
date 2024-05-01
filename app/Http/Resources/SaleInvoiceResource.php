<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SaleInvoiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'SaleInvoiceId'=>$this->id,
            'VoucherNo' => $this->voucher_no,
            'SaleInvoiceDateTime'=> $this->sale_invoice_date_time,
            'TotalAmount'=> $this->total_amount,
            'Discount'=> $this->discount,
            'Tax'=> $this->tax,
            'PaymentType'=> $this->payment_type,
            'PaymentAmount'=> $this->payment_amount,
            'ReceiveAmount'=> $this->receive_amount,
            'Change' => $this->change
        ];
    }
}
