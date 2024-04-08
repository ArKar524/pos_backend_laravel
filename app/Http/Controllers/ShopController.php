<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShopRequest;
use App\Http\Resources\ShopResource;
use App\Models\Shop;
use App\Services\ShopService;

class ShopController extends Controller
{
    protected $shop;

    function __construct(ShopService $shop)
    {
        $this->shop = $shop;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $shops = ShopResource::collection(Shop::get());
        return response()->json([
            'data' => $shops,
            'status' => true
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ShopRequest $request)
    {
        // return $request->all();
        $data = $request->validated();
        $data['shop_code'] = Shop::generateShopCode();
        // return $data;
        $shop = $this->shop->insert($data);

        if ($shop) {
            return response()->json([
                'data' => $shop,
                'status' => true
            ], 200);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $shop = new ShopResource($this->shop->getDataById($id));
        // dd($shop);
        if ($shop) {
            return response()->json([
                'data' => $shop,
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
     * Update the specified resource in storage.
     */
    public function update(ShopRequest $request, string $id)
    {

        $shop = $this->shop->update($request->all(), $id);
        // return $shop;

        if ($shop) {
            return response()->json([
                'data' => $shop,
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
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $shop = $this->shop->destroy($id);
        if ($shop) {
            return response()->json([
                'data' => $shop,
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