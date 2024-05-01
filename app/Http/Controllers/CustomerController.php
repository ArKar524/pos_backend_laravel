<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerRequest;
use Illuminate\Http\Request;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use App\Services\CustomerService;
use App\Traits\HttpResponses;

class CustomerController extends Controller
{
    use HttpResponses;
    protected $customer;

    function __construct(CustomerService $customer)
    {
        $this->customer = $customer;
    }

    /**
    * @OA\Get( 
    *   path="/api/v1/customer",
    *    summary="Get customer details",
    *   operationId="getCustomer",
    *     tags={"Customer"},
    *   @OA\Response(response="200", description="Success",  @OA\JsonContent()),
    * security={{"bearerAuth":{}}}
    * )
    */
    public function index()
    {
        $customers = CustomerResource::collection(Customer::get());
        return $this->success($customers, "success", 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

     /**

 * @OA\Post(
 *     path="/api/v1/customer",
 *     summary="Post all customer",
 *     operationId="postCustomer",
 *     tags={"Customer"},
 *      @OA\Parameter( name="customerName", in="query", description="customer Name",required=true, @OA\Schema(type="string")),
 *      @OA\Parameter( name="dateOfBirth", in="query", description="date of birth",required=true, @OA\Schema(type="string", format="date")),
 *      @OA\Parameter( name="mobileNo", in="query", description="mobile No",required=true, @OA\Schema(type="string")),
 *      @OA\Parameter( name="stateCode", in="query", description="address",required=false, @OA\Schema(type="string")),
 *      @OA\Parameter( name="townshipCode", in="query", description="gender",required=false, @OA\Schema(type="string")),

 *     @OA\Response(response=200, description="Successful operation",  @OA\JsonContent() ),
 *     security={{"bearerAuth":{}}}
 * )
 */
    public function store(CustomerRequest $request)
    {
        
        // return $request->all();
        $validatedData = $request->validated();

        $customerCode =  "Cus_" . mt_rand(3000, 999999);

        $validatedData["customerCode"] = $customerCode;
   
        $customer = $this->customer->insert($validatedData);

        $resCus = CustomerResource::make($customer);
        if ($customer) {
            return $this->success($resCus, "success", 200);
            
        }
    }

        /**
     * @OA\Get(
     *     path="/api/v1/customer/{id}",
     *     summary="Show customer",
     *     operationId="showCustomer",
     *     tags={"Customer"},
     *     @OA\Parameter( name="id", in="path", description="ID of the customer member", required=true,
     *       @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *@OA\Response(  response=200, description="Successful operation",  @OA\JsonContent()  ),
    *    security={{"bearerAuth":{}}}
    * )
    */
    public function show(string $id)
    {
        $customer = $this->customer->getDataById($id);

        $resCus = CustomerResource::make($customer);

        if ($customer) {
            return $this->success($resCus, "success", 200);

        }else{
            return $this->error($resCus, 'No data found', 404);

        }
    }

           /**

 * @OA\Put(
 *     path="/api/v1/customer/{id}",
 *     summary="update all customer",
 *     operationId="updateCustomer",
 *     tags={"Customer"},
 *     @OA\Parameter( name="id", in="path", description="Enter Id you want to update", required=true,
 *       @OA\Schema(
 *             type="integer",
 *             format="int64"
 *         )
 *     ),
 *      @OA\Parameter( name="customerName", in="query", description="customer Name",required=false, @OA\Schema(type="string")),
 *      @OA\Parameter( name="dateOfBirth", in="query", description="date of birth",required=false, @OA\Schema(type="string", format="date")),
 *      @OA\Parameter( name="mobileNo", in="query", description="mobile No",required=false, @OA\Schema(type="string")),
 *      @OA\Parameter( name="stateCode", in="query", description="address",required=false, @OA\Schema(type="string")),
 *      @OA\Parameter( name="townshipCode", in="query", description="gender",required=false, @OA\Schema(type="string")),

 *     @OA\Response(response=200, description="Successful operation",  @OA\JsonContent() ),
 *     security={{"bearerAuth":{}}}
 * )
 */
    public function update(Request $request, string $id)
    {
        $customer =  $this->customer->update($request->validated(), $id);
        $resCus = CustomerResource::make($customer);

        if($customer) {
            return $this->success($resCus, "success", 200);

       }else {
        return $this->error($resCus, 'No data found', 404);
  
       }
    }
/**

 * @OA\Delete(
 *     path="/api/v1/customer/{id}",
 *     summary="delete customer",
 *     operationId="deleteCustomer",
 *     tags={"Customer"},
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
    public function destroy(string $id)
    {
        $customer =   $this->customer->destroy($id);
      
        if($customer) {
            return $this->success(null, "success", 200);

       }else {
        return $this->error(null, 'No data found', 404);

       }
    }
}
