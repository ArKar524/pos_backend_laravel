<?php

namespace App\Services;

use App\Models\SaleInvoice;
use App\Services\CommonService; 

class SaleInvoiceService extends CommonService
{

    public function connection()
    {
        return new SaleInvoice();
    }


    public function getDataByVoucherNo($no){
        return $this->connection()->query()->where("voucher_no", "$no")->with('staff')->first();
 
    }

    public function getDataById($id)
    {
        return $this->connection()->query()->where("id", $id)->with('staff')->first();
    }

   
     public function destroy($id)
    {
        return $this->connection()->query()->where('id', $id)->delete();
    }

}



