<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShopRequest;
use App\Http\Resources\ShopResource;
use App\Models\Shop;
use App\Services\ShopService;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class ShopController extends Controller
{
     use HttpResponses;
    protected $shop;

    function __construct(ShopService $shop)
    {
        $this->shop = $shop;
    }

   /**
* @OA\Get( 
*   path="/api/v1/shop",
*    summary="Get logged-in staff details",
*   operationId="getShop",
*     tags={"Shop"},
*   @OA\Response(response="200", description="Success",  @OA\JsonContent()),
* security={{"bearerAuth":{}}}
* )
*/
    public function index()
    {
        $shops = ShopResource::collection(Shop::get());
        
        return $this->success($shops, "success", 200);
    }

     /**

 * @OA\Post(
 *     path="/api/v1/shop",
 *     summary="Post all shop",
 *     operationId="postShop",
 *     tags={"Shop"},
 *      @OA\Parameter( name="shop_name", in="query", description="shop Name",required=true, @OA\Schema(type="string")),
 *      @OA\Parameter( name="mobile_no", in="query", description="mobile No",required=true, @OA\Schema(type="string")),
 *      @OA\Parameter( name="address", in="query", description="address",required=true, @OA\Schema(type="string")),

 *     @OA\Response(response=200, description="Successful operation",  @OA\JsonContent() ),
 *     security={{"bearerAuth":{}}}
 * )
 */
    public function store(ShopRequest $request)
    {
      
        $data = $request->validated();
        $data['shop_code'] = Shop::generateShopCode();
        $shop = $this->shop->insert($data);

        if ($shop) {
            return $this->success(ShopResource::make($shop), "success", 200);
        }
    }

            /**
     * @OA\Get(
     *     path="/api/v1/shop/{id}",
     *     summary="Show shop",
     *     operationId="showShop",
     *     tags={"Shop"},
     *     @OA\Parameter( name="id", in="path", description="ID of the Shop", required=true,
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
        $shop = new ShopResource($this->shop->getDataById($id));
        // dd($shop);
        if ($shop) {
            return $this->success(ShopResource::make($shop), "success", 200);

        } else {
            return $this->error($shop, 'No data found', 404);

        }
    }

        /**

 * @OA\Put(
 *     path="/api/v1/shop/{id}",
 *     summary="update all shop",
 *     operationId="updateShop",
 *     tags={"Shop"},
 *     @OA\Parameter( name="id", in="path", description="Enter Id you want to update", required=true,

 *     ),
 *      @OA\Parameter( name="shop_name", in="query", description="shop Name",required=false, @OA\Schema(type="string")),
 *      @OA\Parameter( name="mobile_no", in="query", description="mobile No",required=false, @OA\Schema(type="string")),
 *      @OA\Parameter( name="address", in="query", description="address",required=false, @OA\Schema(type="string")),

 *     @OA\Response(response=200, description="Successful operation",  @OA\JsonContent() ),
 *     security={{"bearerAuth":{}}}
 * )
 */
    public function update(Request $request, string $id)
    {

        $shop = $this->shop->update($request->all(), $id);
        // return $shop;

        if ($shop) {
            return $this->success(ShopResource::make($shop), "success", 200);

        } else {
            return $this->error($shop, 'No data found', 404);

        }
    }

   /**

 * @OA\Delete(
 *     path="/api/v1/shop/{id}",
 *     summary="delete shop",
 *     operationId="deleteShop",
 *     tags={"Shop"},
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
        $shop = $this->shop->destroy($id);
        if($shop) {
            return $this->success(null, 'deleted', 200);
       }else {
        return $this->error(null, "No data found",404 );    

       }
    }
}