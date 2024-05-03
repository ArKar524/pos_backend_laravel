<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\ProductCategoryResource;
use Illuminate\Http\Resources\Json\JsonResource;


class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'ProductId' => $this->id,
            'ProductCode' => $this->product_code,
            'ProductName' => $this->product_name,
            'Price' => $this->price,

            'ProductCategory' => ProductCategoryResource::make($this->ProductCategory)

        ];
    }
}
