<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "CustomerId" => $this->id,
            "CustomerCode" => $this->customerCode,
            "CustomerName" => $this->customerName,
            "MobileNo"=> $this->mobileNo,
            "DateOfBirth"=> $this->dateOfBirth,            
            "Gender"=> $this->gender,
            "StateCode" => $this->stateCode,
            "TownshipCode" => $this->townshipCode
        ];
    }
}

