<?php

namespace App\Services;

use App\Models\ProductCategory;
use App\Models\Shop;
use App\Services\CommonService;

class ShopService extends CommonService
{
    public function connection()
    {
        return new Shop();
    }

    public function getDataById($id)
    {
        return $this->connection()->query()->where('id', $id)->first();
    }

    public function update(array $data, int $id)
    {
        return $this->connection()->query()->where('id', $id)->update($data);
    }

    public function destroy($id)
    {
        return $this->connection()->query()->where('id', $id)->delete();
    }
}