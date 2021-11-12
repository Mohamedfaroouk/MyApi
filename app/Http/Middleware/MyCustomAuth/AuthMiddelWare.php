<?php

namespace App\Http\Middleware\MyCustomAuth;

use App\Traits\ApiTrait;
use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;

class AuthMiddelWare
{
    use ApiTrait;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next,  $guard=null)
    {
        if($guard != null){

            auth()->shouldUse($guard);

            $token = $request->header('auth-token');

            $request->headers->set('auth-token', (string) $token, true);
            $request->headers->set('Authorization', 'Bearer '.$token, true);
            try {
                $user = JWTAuth::parseToken()->authenticate();
            } catch (TokenExpiredException $e) {

                return  $this -> returnError('401',"please login first");

            } catch (JWTException $e) {

                return  $this -> returnError('401', "please login first");
            }

        }
         return $next($request);

    }
}
