<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Services\ProductService;
use App\Http\Resources\ProductResource;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Traits\HttpResponses;

class ProductController extends Controller
{
    use HttpResponses;
    protected $product;

    public function __construct(ProductService $product){
        $this->product = $product;
    }

    /**
    * @OA\Get( 
    *   path="/api/v1/product",
    *    summary="Get logged-in product details",
    *   operationId="getProduct",
    *     tags={"Product"},
    *   @OA\Response(response="200", description="Success",  @OA\JsonContent()),
    * security={{"bearerAuth":{}}}
    * )
    */
    public function index()
    {
        $productList = ProductResource::collection(Product::with('ProductCategory')->get());
        // return $productList;
        return $this->success($productList, 'success', 200);

    }

     /**

 * @OA\Post(
 *     path="/api/v1/product",
 *     summary="Post all product",
 *     operationId="postProduct",
 *     tags={"Product"},
 *      @OA\Parameter( name="product_name", in="query", description="product Name",required=true, @OA\Schema(type="string")),
 *      @OA\Parameter( name="dateOfBirth", in="query", description="date of birth",required=true, @OA\Schema(type="string", format="date")),
 *      @OA\Parameter( name="price", in="query", description="mobile No",required=true, @OA\Schema(type="string")),
 *      @OA\Parameter( name="ProductCategoryId", in="query", description="product category id",required=true, @OA\Schema(type="number")),

 *     @OA\Response(response=200, description="Successful operation",  @OA\JsonContent() ),
 *     security={{"bearerAuth":{}}}
 * )
 */
    public function store(StoreProductRequest $request)
    {
        $productCode = 'P'.mt_rand(3000, 999999);
        $validatedData['product_code'] = $productCode;
        $validatedData['product_name'] = $request->product_name;
        $validatedData['ProductCategoryId'] = $request->ProductCategoryId;
        $validatedData['price'] = $request->price;

        
        $product = $this->product->insert($validatedData);

        $resProduct = ProductResource::make($product);

        if($product){
            return $this->success($resProduct, 'success', 200);

        }
    }

            /**
     * @OA\Get(
     *     path="/api/v1/product/{id}",
     *     summary="Show product",
     *     operationId="showProduct",
     *     tags={"Product"},
     *     @OA\Parameter( name="id", in="path", description="ID of the product", required=true,
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
        $product = $this->product->getProductById($id);

        $resProduct = ProductResource::make($product);

        if($product){
       
                return $this->success($resProduct, 'success', 200);
        }else{
            return $this->error($resProduct, 'No data found', 404);

        }
    }



          /**

 * @OA\Put(
 *     path="/api/v1/product/{id}",
 *     summary="update all product",
 *     operationId="updateProduct",
 *     tags={"Product"},
 *     @OA\Parameter( name="id", in="path", description="Enter Id you want to update", required=true,
 *       @OA\Schema(
 *             type="integer",
 *             format="int64"
 *         )
 *     ),
 *      @OA\Parameter( name="product_name", in="query", description="product Name",required=false, @OA\Schema(type="string")),
 *      @OA\Parameter( name="dateOfBirth", in="query", description="date of birth",required=false, @OA\Schema(type="string", format="date")),
 *      @OA\Parameter( name="price", in="query", description="mobile No",required=false, @OA\Schema(type="string")),
 *      @OA\Parameter( name="ProductCategoryId", in="query", description="product category id",required=false, @OA\Schema(type="number")),

 *     @OA\Response(response=200, description="Successful operation",  @OA\JsonContent() ),
 *     security={{"bearerAuth":{}}}
 * )
 */
    public function update(UpdateProductRequest $request,string $id)
    {
        $product = $this->product->update($request->validated(),$id);
        $resProduct = ProductResource::make($product);
        if($product){
            return $this->success($resProduct, 'success', 200);

        }else{
            return $this->error($resProduct, 'No data found', 404);

        }
    }

   /**

 * @OA\Delete(
 *     path="/api/v1/product/{id}",
 *     summary="delete product",
 *     operationId="deleteProduct",
 *     tags={"Product"},
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
    public function destroy(int $id)
    {
        $product = $this->product->destroy($id);

        if($product) {
            return $this->success(null, 'deleted', 200);
       }else {
        return $this->error(null, "No data found",404 );    

       }
    }
}
