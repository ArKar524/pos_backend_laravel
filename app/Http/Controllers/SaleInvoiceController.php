<?php

namespace App\Http\Controllers;

use App\Models\SaleInvoice;
use App\Http\Requests\StoreSaleInvoiceRequest;
use App\Http\Requests\UpdateSaleInvoiceRequest;
use App\Http\Resources\SaleInvoiceResource;
use App\Models\SaleInvoiceDetail;
use App\Services\SaleInvoiceService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Traits\HttpResponses;


class SaleInvoiceController extends Controller
{
    use HttpResponses;
    protected $invoice;

    public function __construct(SaleInvoiceService $invoice)
    {
        $this->invoice = $invoice;

    }

    /**
     * @OA\PathItem(
     *  title= "My first API",
     *  version = "0.1"
     * )
     *
     * **/

    public function index()
    {
        $saleInvoices = SaleInvoice::with('staff')->get();

        return $this->success(SaleInvoiceResource::collection($saleInvoices), 'success', 200);

    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSaleInvoiceRequest $request)
    {
        DB::beginTransaction();
        try {

             $validatedData = $request->validated();
            $voucher_no = "V_".mt_rand(3000, 999999);
            $validatedData['sale_invoice_date_time'] = Carbon::now()->toDateTimeString();
            $validatedData['voucher_no'] = $voucher_no;
            $validatedData['total_amount'] = $request->total_amount;
            $validatedData['discount'] = $request->discount;
            $validatedData['tax'] = $request->tax;
            $validatedData['payment_type'] = $request->payment_type;
            $validatedData['payment_amount'] = $request->payment_amount;
            $validatedData['receive_amount']  = $request->receive_amount;
            $validatedData['change'] = $request->change;
            $validatedData['staff_id'] = $request->staff_id;
            $saleInvoice = $this->invoice->insert($validatedData);

            foreach ($request->items as $item) {


                $detail = new SaleInvoiceDetail();

                $detail->voucher_no = $saleInvoice->voucher_no;
                $detail->product_code = $item['product_code'];
                $detail->quantity = $item['quantity'];
                $detail->price = $item['price'];
                $detail->amount = $item['amount'];

                $detail->save();

            }

            DB::commit();
        } catch (\Throwable $th) {
           DB::rollBack();
           throw $th;
        }

        return $this->success(SaleInvoiceResource::make($saleInvoice), 'success', 200);

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $saleInvoice = $this->invoice->getDataById($id);

        $resInvoice = SaleInvoiceResource::make($saleInvoice);

        if ($saleInvoice) {
            return $this->success($resInvoice, 'success', 200);

        }else{
            return $this->error($saleInvoice, 'No data found', 404);

        }
    }


    public function getDataByVoucherNo($voucher_no)
    {
        $saleInvoice = $this->invoice->getDataByVoucherNo($voucher_no);

        if ($saleInvoice) {
            return $this->success(SaleInvoiceResource::make($saleInvoice), 'success', 200);

        }else{
            return $this->error($saleInvoice, 'No data found', 404);

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $saleInvoice = $this->invoice->destroy($id);

        if($saleInvoice) {
            return $this->success(null, 'deleted', 200);
       }else {
        return $this->error(null, "No data found",404 );
        }
    }
}
