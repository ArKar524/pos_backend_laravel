<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StaffResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "StaffId" => $this->id,
            "StaffCode" => $this->staffCode,
            "StaffName" => $this->staffName,
            "DateOfBirth"=> $this->dateOfBirth,
            "MobileNo"=> $this->mobileNo,
            "Address" => $this->address,
            "Gender"=> $this->gender,
            "Position" => $this->position,
            "shop" => ShopResource::make($this->shop)
        ];
    }
}
