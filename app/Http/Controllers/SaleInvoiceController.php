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
use Illuminate\Contracts\Database\Eloquent\Builder;

class SaleInvoiceController extends Controller
{
    use HttpResponses;
    protected $invoice;

    public function __construct(SaleInvoiceService $invoice)
    {
        $this->invoice = $invoice;
       
    }

        /**
    * @OA\Get( 
    *   path="/api/v1/sale-invoices",
    *    summary="Get Sale invoices",
    *   operationId="getSaleInvoices",
    *     tags={"SaleInvoice"},
    *   @OA\Response(response="200", description="Success",  @OA\JsonContent()),
    * security={{"bearerAuth":{}}}
    * )
    */

    public function index()
    {
        $saleInvoices = SaleInvoice::with("staff","customer")->get();

        $resInvoice =SaleInvoiceResource::collection($saleInvoices);

        return $this->success($resInvoice, 'success', 200);
        
    }

   
     /**

 * @OA\Post(
 *     path="/api/v1/sale-invoices",
 *     summary="Post all sale-invoices",
 *     operationId="postSaleInvoice",
 *     tags={"SaleInvoice"},
 *      @OA\Parameter( name="total_amount", in="query", description="mobile No",required=true, @OA\Schema(type="string")),
 *      @OA\Parameter( name="discount", in="query", description="address",required=false, @OA\Schema(type="string")),
 *      @OA\Parameter( name="tax", in="query", description="gender",required=false, @OA\Schema(type="string")),
 *      @OA\Parameter( name="payment_type", in="query", description="position",required=true, @OA\Schema(type="string")),
 *      @OA\Parameter( name="payment_amount", in="query", description="shop id",required=true, @OA\Schema(type="number")),
 *      @OA\Parameter( name="receive_amount", in="query", description="shop id",required=true, @OA\Schema(type="number")),
 *      @OA\Parameter( name="change", in="query", description="shop id",required=false, @OA\Schema(type="number")),
 *      @OA\Parameter( name="staff_id", in="query", description="shop id",required=true, @OA\Schema(type="number")),
 *      @OA\Parameter( name="customer_id", in="query", description="shop id",required=true, @OA\Schema(type="number")),

 *     @OA\Response(response=200, description="Successful operation",  @OA\JsonContent() ),
 *     security={{"bearerAuth":{}}}
 * )
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
             $validatedData['customer_id'] = $request->customer_id;
            $saleInvoice = $this->invoice->insert($validatedData);

            $resInvoice = SaleInvoiceResource::make($saleInvoice);
            
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

        return $this->success($resInvoice, 'success', 200);
 
    }

            /**
     * @OA\Get(
     *     path="/api/v1/sale-invoices/{id}",
     *     summary="Show sale-invoices",
     *     operationId="showSaleInvoice",
     *     tags={"SaleInvoice"},
     *     @OA\Parameter( name="id", in="path", description="ID of the Sale Invoice", required=true,
     *       @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *@OA\Response(  response=200, description="Successful operation",  @OA\JsonContent()  ),
    *    security={{"bearerAuth":{}}}
    * )
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

             /**
     * @OA\Get(
     *     path="/api/v1/sale-invoices/get-by-voucher/{voucher_no}",
     *     summary="search by voucher no",
     *     operationId="showSaleInvoiceByVoucher_no",
     *     tags={"SaleInvoice"},
     *     @OA\Parameter( name="voucher_no", in="path", description="voucher no", required=true,
     *       @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *@OA\Response(  response=200, description="Successful operation",  @OA\JsonContent()  ),
    *    security={{"bearerAuth":{}}}
    * )
    */
  
    public function getDataByVoucherNo($voucher_no)
    {
        $saleInvoice = $this->invoice->getDataByVoucherNo($voucher_no);
        $resInvoice = SaleInvoiceResource::make($saleInvoice);

        if ($saleInvoice) {
            return $this->success($resInvoice, 'success', 200);

        }else{
            return $this->error($saleInvoice, 'No data found', 404);
           
        }
    }

   /**

 * @OA\Delete(
 *     path="/api/v1/sale-invoices/{id}",
 *     summary="delete sale-invoices",
 *     operationId="deleteSaleInvoice",
 *     tags={"SaleInvoice"},
  *     @OA\Parameter( name="id", in="path", description="Enter Id you want to delete", required=true,
 *       @OA\Schema(
 *             type="integer",
 *             format="int64"
 *         )
 *     ),
 *      @OA\Response(  response=200, description="Successful operation",  @OA\JsonContent()  ),

 *     security={{"bearerAuth":{}}}
 * )
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
