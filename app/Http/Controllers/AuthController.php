<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Validator as confirm;

class AuthController extends Controller
{
    
    use HttpResponses;

    // login Function
    // In Postman
    // form-data {
    //  email ->
    //  password ->
    // }

     /**

* @OA\Info(title="Swagger with Laravel",version="1.0.0",)

* @OA\SecurityScheme( type="http", securityScheme="bearerAuth", scheme="bearer", bearerFormat="JWT" )

*/

    /**
     * 

* @OA\Post(
* path="/api/login",
* summary="Authenticate user and generate JWT token",
*  tags={"Auth"},

* @OA\Parameter( name="email", in="query", description="User’s email", required=true, @OA\Schema(type="string")),

* @OA\Parameter( name="password", in="query", description="User’s password", required=true, @OA\Schema(type="string") ),

* @OA\Response(response="200", description="Login successful", @OA\JsonContent()),

* @OA\Response(response="401", description="Invalid credentials", @OA\JsonContent())

* )

*/
    public function login(Request $request)
    {
        $validator =
            Validator::make($request->all(), [
                'email' => ['required', 'email'],
                'password' => ['required', 'min:8'],
            ]);

        if ($validator->fails()) {
            return $this->error(
                '',
                $validator->errors()->all(),
                422
            );
        }


        $user = User::where('email', $request->email)->first();

        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                return $this->success(
                    [
                        'user' => $user,
                        'token' => $user->createToken(time())->plainTextToken
                    ],
                    'Login Success',
                    200
                );
            }
        }
        return $this->error(
            '',
            'Credentials Do Not Match',
            '401'
        );
    }


    // login Function
    // In Postman
    // form-data {
    // name ->
    // email ->
    // phone ->
    // address ->
    // password ->
    // password_confirmation ->
    // }

 /**

* @OA\Post(

* path="/api/register",

* summary="Register a new user",
*  tags={"Auth"},



* @OA\Parameter( name="name", in="query", description="User’s name", required=true, @OA\Schema(type="string") ),

* @OA\Parameter(name="email",in="query",description="User’s email",required=true,@OA\Schema(type="string")),
* @OA\Parameter( name="phone", in="query", description="User’s phone", required=true, @OA\Schema(type="string") ),
* @OA\Parameter( name="address", in="query", description="User’s address", required=true, @OA\Schema(type="string") ),
* @OA\Parameter(name="password",in="query",description="User’s password",required=true,@OA\Schema(type="string")),
* @OA\Parameter(name="password_confirmation", in="query", description="confirm password", required=true, @OA\Schema(type="string")),

* @OA\Response(response="201", description="User registered successfully", @OA\JsonContent()),

* @OA\Response(response="422", description="Validation errors", @OA\JsonContent())

* )

*/
     
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'min:8', 'max:255', 'unique:users'],
            'email' => ['required', 'email', 'unique:users'],
            'phone' => ['required', 'min:10'],
            'address' => ['required'],
            'password' => ['required', 'min:8', 'confirmed:password'],

        ]);
        if ($validator->fails()) {
            return $this->error(
                "",
                $validator->errors()->all(),
                422
            );
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'password' => Hash::make($request->password),
        ]);

        return $this->success([
            'user' => $user,
            'token' => $user->createToken(time())->plainTextToken,
        ]);
    }
}
