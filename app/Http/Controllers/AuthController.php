<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\User;
use App\Traits\ApiTrait;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Config;

class AuthController extends Controller
{
    use ApiTrait;


    public function login(Request $request)

{
    try{

        $validator = Validator::make($request->all(), Config::get('AuthCustomValidation.loginRules'),Config::get('AuthCustomValidation.loginMessages'));

        if ($validator->fails()) {

            return $this->returnError("",$validator->messages()->first());
        }

        $credentials = $request->only(['email', 'password']);
            $token = Auth::guard("user-api")->attempt($credentials);

            if (!$token)
                return $this->returnError('E001', 'بيانات الدخول غير صحيحة');

            $user =Auth::guard("user-api")->user();
         $user->api_token = $token;
            //return token
            return $this->returnData('user', $user);

        } catch (\Exception $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }


    }


/////////////////////////////////////////////////////////////////


     public function register(Request  $request)
    {
        try {

            $validator = Validator::make($request->all(), Config::get('AuthCustomValidation.registerRules'),Config::get('AuthCustomValidation.registermessages'));

            if ($validator->fails()) {

                return $this->returnError("",$validator->messages()->first());
            }
    User::create([
    "name"=>$request->name,
    "email"=>$request->email,
    "password"=> Hash::make($request->password),
    "favourite"=>[],
    "cart"=>[]
    ]);

return $this->returnSuccessMessage("Register done successfully");

    } catch (\Exception $ex) {
    return $this->returnError($ex->getCode(), $ex->getMessage());
    }
    }

////////////////////////////////////////////

    public function getProfile()
    {
        $user =Auth::user();
        return $this->returndata("user",$user) ;
    }

    /////////////////////////////////////

    public function logout(Request  $request)
    {
        $token = $request -> header('auth-token');
        if($token){
            try {

                JWTAuth::setToken($token)->invalidate(); //logout
            }catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e){
                return  $this -> returnError('','some thing went wrong');
            }
            return $this->returnSuccessMessage('Logged out successfully');
        }else{
         return   $this -> returnError('','some thing went wrong');
        }

    }
    }

