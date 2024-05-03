<?php

namespace App\Services;

use App\Models\ProductCategory;
use App\Services\CommonService;

class ProductCategoryService extends CommonService
{
    public function connection()
    {
        return  new ProductCategory();
    }

    public function getDataById($id)
    {
        return $this->connection()->query()->where('ProductCategoryId', $id)->first();
    }

     public function update(array $data, int $id)
    {
        return $this->connection()->query()->where('ProductCategoryId', $id)->update($data);
    }

     public function destroy($id)
    {
        return $this->connection()->query()->where('ProductCategoryId', $id)->delete();
    }

    public function insert($request) {
        $productCategoryCode = 'PC'.mt_rand(3000, 999999);
        $data['ProductCategoryCode'] = $productCategoryCode;
        $data['ProductCategoryName'] = $request['ProductCategoryName'];

        return $this->connection()->create($data);
    }
}