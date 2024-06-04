<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use App\Models\ProductCategory;
use App\Services\ProductCategoryService;
use App\Http\Resources\ProductCategoryResource;
use App\Http\Requests\StoreProductCategoryRequest;

class ProductCategoryController extends Controller
{
    use HttpResponses;
    protected $productCategory;


    public function __construct(ProductCategoryService $productCategory)
    {
        $this->productCategory = $productCategory;
    }


      /**
    * @OA\Get( 
    *   path="/api/v1/product-categories",
    *    summary="Get customer details",
    *   operationId="getProductCategories",
    *     tags={"ProductCategory"},
    *   @OA\Response(response="200", description="Success",  @OA\JsonContent()),
    * security={{"bearerAuth":{}}}
    * )
    */


    public function index()
    {
        $productCategory = ProductCategory::get();

        $categoryList = ProductCategoryResource::collection($productCategory);

        return $this->success($categoryList, 'success', 200);
    }

     /**

 * @OA\Post(
 *     path="/api/v1/product-categories",
 *     summary="Post all product-categories",
 *     operationId="postProductCategory",
 *     tags={"ProductCategory"},
 *      @OA\Parameter( name="ProductCategoryName", in="query", description="Product Category Name",required=true, @OA\Schema(type="string")),
 *     @OA\Response(response=200, description="Successful operation",  @OA\JsonContent() ),
 *     security={{"bearerAuth":{}}}
 * )
 */
    public function store(StoreProductCategoryRequest $request)
    {
        $productCategoryCode = 'PC'.mt_rand(3000, 999999);

        $data['ProductCategoryCode'] = $productCategoryCode;
        $data['ProductCategoryName'] = $request->ProductCategoryName;

        // return $data;

        $productCategory = $this->productCategory->insert($data);
        $productCategory['ProductCategoryId'] = $productCategory->id;
        $resProductCategory = ProductCategoryResource::make($productCategory);
        if ($productCategory) {
            return $this->success($resProductCategory,'success','200');
        }
    }

     /**
 * @OA\Get(
 *     path="/api/v1/product-categories/{ProductCategoryId}",
 *     summary="Show product-categories",
 *     operationId="showProductCategories",
 *     tags={"ProductCategory"},
 *     @OA\Parameter( name="ProductCategoryId", in="path", description="ID of the productCategory", required=true,
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
        $productCategory = $this->productCategory->getDataById($id);

        if ($productCategory) {
            return response()->json([
                'data' => $productCategory,
                'status' => true
            ], 200);
        } else {
            return response()->json([
                'message' => 'No data found',
                'status' => false
            ], 404);
        }
    }

       /**

 * @OA\Put(
 *     path="/api/v1/product-categories/{ProductCategoryId}",
 *     summary="update all product-categories",
 *     operationId="updateProductCategory",
 *     tags={"ProductCategory"},
 *     @OA\Parameter( name="ProductCategoryId", in="path", description="Enter Id you want to update", required=true,
 *       @OA\Schema(
 *             type="integer",
 *             format="int64"
 *         )
 *     ),
 *      @OA\Parameter( name="ProductCategoryCode", in="query", description="ProductCategory Code",required=false, @OA\Schema(type="string")),
 *      @OA\Parameter( name="ProductCategoryName", in="query", description="ProductCategory Name",required=false, @OA\Schema(type="string")),

 *     @OA\Response(response=200, description="Successful operation",  @OA\JsonContent() ),
 *     security={{"bearerAuth":{}}}
 * )
 */
    public function update(Request $request, string $id)
    {
        $productCategory = $this->productCategory->update($request->all(), $id);

        if ($productCategory) {
            return response()->json([
                'message' => 'Successfully updated data',
                'status' => true
            ], 200);
        } else {
            return response()->json([
                'message' => 'No data found',
                'status' => false
            ], 404);
        }
    }

        /**

    * @OA\Delete(
    *     path="/api/v1/product-categories/{ProductCategoryId}",
    *     summary="delete product-categories",
    *     operationId="deleteProductCategory",
    *     tags={"ProductCategory"},
    *     @OA\Parameter( name="ProductCategoryId", in="path", description="Enter Id you want to delete", required=true,
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
        $productCategory = $this->productCategory->destroy($id);

        if ($productCategory) {
            return response()->json([
                'message' => 'Successfully deleted data',
                'status' => true
            ], 200);
        } else {
            return response()->json([
                'message' => 'No data found',
                'status' => false
            ], 404);
        }
    }
}
