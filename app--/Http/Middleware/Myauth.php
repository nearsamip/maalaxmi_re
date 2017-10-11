<?php

namespace App\Http\Middleware;

use Closure;
use App\login_model;

class Myauth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //273151457674264
        $token = $request->header('token');
        $user = login_model::token_check2($token);
        if (empty($user))
        {
            //not allowed to enter to app
            return \Response::json(array('error'=>True,'message'=>'Token is empty or user not found on given token'));
        }
        return $next($request);
    }
}
