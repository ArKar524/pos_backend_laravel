<?php

namespace App\Services;

use App\Models\Product;
use App\Services\CommonService;


class ProductService extends CommonService
{
    public function connection(){
        return new Product();
    }

    public function getProductById($id){
        return $this->connection()->query()->where('id',$id)->first();
    }

    public function update(array $data,string $id){
        return $this->connection()->query()->where('id',$id)->update($data);
    }

    public function destroy($id){
        return $this->connection()->query()->where('id',$id)->delete();
    }

}

