<?php

namespace App\Http\Controllers;

use App\Models\Staff;

use App\Http\Resources\StaffResource;
use App\Http\Requests\StoreStaffRequest;
use App\Http\Requests\UpdateStaffRequest;
use App\Services\StaffService;

class StaffController extends Controller
{

    protected $staff;

    public function __construct(StaffService $staff)
    {
        $this->staff = $staff;
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
        $staff = Staff::get();

        return response()->json([
            "data"=> StaffResource::collection($staff),
            "status" => true
        ], 200);

    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStaffRequest $request)
    {

       $validatedData = $request->validated();

       $staffCode =  "Stf_" . mt_rand(3000, 999999);

       $validatedData["staffCode"] = $staffCode;

       $staff =  $this->staff->insert($validatedData);

        if ($staff) {
            return response()->json([
                'data' => StaffResource::make($staff),
                'message'=>"A Staff is created successfully ",
                'status' => true
            ], 200);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show( $id)
    {
        $staff = $this->staff->getDataById($id);

        if ($staff) {
            return response()->json([
                'data' => StaffResource::make($staff),
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
     * Update the specified resource in storage.
     */
    public function update(UpdateStaffRequest $request, string  $id)
    {
        $staff =  $this->staff->update($request->validated(), $id);

        if($staff) {
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
        $staff =   $this->staff->destroy($id);

        if($staff) {
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
