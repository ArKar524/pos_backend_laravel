<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;


class CustomerController extends Controller
{
    protected $customer;

    function __construct(CustomerService $customer)
    {
        $this->customer = $customer;
    }
    /**
     * @OA\PathItem(
     *  title= "My first API",
     *  version = "0.1"
     * )
     *
     * **/


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customer = CustomerResource::collection(Customer::get());
        return $customer;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // return $request->all();
        $data = $request->validated();

        $customer = $this->customer->insert($data);

        if ($customer) {
            return response()->json([
                'data' => CustomerResource::make($customer),
                'message'=>"A customer account is created successfully ",
                'status' => true
            ], 200);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $customer = $this->customer->getDataById($id);

        if ($customer) {
            return response()->json([
                'data' => CustomerResource::make($customer),
                'status' => true
            ], 200);
        }else{
            return response()->json([
                'message' => 'No data found',
                'status' => false
            ], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $customer =  $this->customer->update($request->validated(), $id);

        if($customer) {
            return response()->json([
                'message' => 'Successfully updated data',
                'status' => true
            ], 200);
       }else {
            return response()->json([
                'message' => 'No data found',
                'status' => false
            ], 404);
       }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $customer =   $this->customer->destroy($id);

        if($customer) {
            return response()->json([
                'message' => 'Successfully deleted data',
                'status' => true
            ], 200);
       }else {
            return response()->json([
                'message' => 'No data found',
                'status' => false
            ], 404);
       }
    }
}
