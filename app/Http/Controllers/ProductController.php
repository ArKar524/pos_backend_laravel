<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Services\ProductService;
use App\Http\Resources\ProductResource;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    protected $product;

    public function __construct(ProductService $product){
        $this->product = $product;
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

        $productList = ProductResource::collection(Product::get());
        return $productList;
        return response()->json([
            'message' =>'success',
            'data' => $productList
        ],200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {

        $validatedData = $request->validate();
        $productCode = 'P'.mt_rand(3000, 999999);
        $validatedData['productCode'] = $productCode;

        $product = $this->product->insert($validatedData);

        if($product){
            return[
                response()->json([
                    'data' => $product,
                    'message' => 'success'
                ],200)
            ];
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $product = $this->product->getProductById($id);

        if($product){

            return[
                response()->json([
                    'data' => $product,
                    'message' => 'success'
                ],200)

            ];
        }else{
            return [response()->json([
                'message' => "No product data found",
                'status' => false
            ],404)];
        }
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request,string $id)
    {
        $product = $this->product->update($request->validated(),$id);
        if($product){
            return [
                response()->json([
                    'message' => 'Data updated Successfully',
                    'status' => true
                ],200)
            ];
        }else{
            return [
                response()->json([
                    'message' => "No data found",
                    'status' => false
                ],404)
            ];
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $product = $this->product->destroy($id);

        if($product){
            return [
                response()->json([
                    'message' => "Delete successfully",
                    'status' => true
                ],200)
            ];
        }else{
            return [
                response()->json([
                    'message' => "No data found",
                    'status' => false
                ],404)
            ];
        }
    }
}
