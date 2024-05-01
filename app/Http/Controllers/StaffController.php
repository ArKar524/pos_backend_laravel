<?php

namespace App\Http\Controllers;

use App\Models\Staff;

use App\Http\Resources\StaffResource;
use App\Http\Requests\StoreStaffRequest;
use App\Http\Requests\UpdateStaffRequest;
use App\Services\StaffService;
use App\Traits\HttpResponses;

class StaffController extends Controller
{
    use HttpResponses;
    protected $staff;

   

    public function __construct(StaffService $staff)
    {
        $this->staff = $staff;
    }

/**
* @OA\Get( 
*   path="/api/v1/staff",
*    summary="Get logged-in staff details",
*   operationId="getStaff",
*     tags={"Staff"},
*   @OA\Response(response="200", description="Success",  @OA\JsonContent()),
* security={{"bearerAuth":{}}}
* )
*/


    public function index()
    {
        $staff = Staff::with('shop')->get();

        $resStaff = StaffResource::collection($staff);

        return $this->success($resStaff, 'success', 200);
        
    }

  /**

 * @OA\Post(
 *     path="/api/v1/staff",
 *     summary="Post all staff",
 *     operationId="postStaff",
 *     tags={"Staff"},
 *      @OA\Parameter( name="staffName", in="query", description="staff Name",required=true, @OA\Schema(type="string")),
 *      @OA\Parameter( name="dateOfBirth", in="query", description="date of birth",required=true, @OA\Schema(type="string", format="date")),
 *      @OA\Parameter( name="mobileNo", in="query", description="mobile No",required=true, @OA\Schema(type="string")),
 *      @OA\Parameter( name="address", in="query", description="address",required=true, @OA\Schema(type="string")),
 *      @OA\Parameter( name="gender", in="query", description="gender",required=true, @OA\Schema(type="string")),
 *      @OA\Parameter( name="position", in="query", description="position",required=true, @OA\Schema(type="string")),
 *      @OA\Parameter( name="shop_id", in="query", description="shop id",required=true, @OA\Schema(type="number")),

 *     @OA\Response(response=200, description="Successful operation",  @OA\JsonContent() ),
 *     security={{"bearerAuth":{}}}
 * )
 */
     
    public function store(StoreStaffRequest $request)
    {
       
       $validatedData = $request->validated();

       $staffCode =  "Stf_" . mt_rand(3000, 999999);

       $validatedData["staffCode"] = $staffCode;
    //    $validatedData["staff_id"] = $request->staff_id;

       $staff =  $this->staff->insert($validatedData);

       $resStaff = StaffResource::make($staff);

        if ($staff) {
            return $this->success($resStaff, "success", 200);
            
        }
    }
     
 /**
 * @OA\Get(
 *     path="/api/v1/staff/{id}",
 *     summary="Show staff",
 *     operationId="showStaff",
 *     tags={"Staff"},
 *     @OA\Parameter( name="id", in="path", description="ID of the staff member", required=true,
 *       @OA\Schema(
 *             type="integer",
 *             format="int64"
 *         )
 *     ),
 *@OA\Response(  response=200, description="Successful operation",  @OA\JsonContent()  ),
 *    security={{"bearerAuth":{}}}
 * )
 */
    public function show( $id)
    {
        $staff = $this->staff->getDataById($id);
        $resStaff = StaffResource::make($staff);

        if ($staff) {
            return $this->success($resStaff, 'success', 200);

        }else{
            return $this->error($staff, 'No data found', 404);
           
        }
    }

 /**

 * @OA\Put(
 *     path="/api/v1/staff/{id}",
 *     summary="update staff",
 *     operationId="updateStaff",
 *     tags={"Staff"},
 *     @OA\Parameter( name="id", in="path", description="Enter Id you want to update", required=true,
 *       @OA\Schema(
 *             type="integer",
 *             format="int64"
 *         )
 *     ),
 *      @OA\Parameter( name="staffName", in="query", description="staff Name",required=false, @OA\Schema(type="string")),
 *      @OA\Parameter( name="dateOfBirth", in="query", description="date of birth",required=false, @OA\Schema(type="string", format="date")),
 *      @OA\Parameter( name="mobileNo", in="query", description="mobile No",required=false, @OA\Schema(type="string")),
 *      @OA\Parameter( name="address", in="query", description="address",required=false, @OA\Schema(type="string")),
 *      @OA\Parameter( name="gender", in="query", description="gender",required=false, @OA\Schema(type="string")),
 *      @OA\Parameter( name="position", in="query", description="position",required=false, @OA\Schema(type="string")),
 *      @OA\Parameter( name="shop_id", in="query", description="shop id",required=false, @OA\Schema(type="number")),

 *      @OA\Response(  response=200, description="Successful operation",  @OA\JsonContent()  ),

 *     security={{"bearerAuth":{}}}
 * )
 */
  
    public function update(UpdateStaffRequest $request, string  $id)
    {
        $staff =  $this->staff->update($request->validated(), $id);
        

        if($staff) {
            $updatedStaff = $this->staff->getDataById($id);
            return $this->success(StaffResource::make($updatedStaff), 'Updated', 200);
       }else {
            return $this->error(null, "No data found",404 );    
       }
    }

 
 /**

 * @OA\Delete(
 *     path="/api/v1/staff/{id}",
 *     summary="delete staff",
 *     operationId="deleteStaff",
 *     tags={"Staff"},
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
        $staff =   $this->staff->destroy($id);

        if($staff) {
            return $this->success(null, 'deleted', 200);
       }else {
        return $this->error(null, "No data found",404 );    
       }
    
    }
}
