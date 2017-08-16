<?php

namespace App\Http\Middleware;

use Closure;
use App\Customer;
use Illuminate\Contracts\Encryption\DecryptException;
class TokenMiddleware
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
        if(!$request->session()->exists('uid') || !$request->session()->exists('email') || !$request->session()->exists('token')){
            return response([
                "status" => "NOTOK",
                "message" => "Invalid Token"
            ]);
        }
        $uid = session('uid');
        $email = session('email');
        $token = session('token');
        $customer = Customer::where('uid', $uid)->where('token', $token)->where('email', $email)->first();
        if(!$customer){
            return response([
                "status" => 'NOT OK',
                "message" => "Invalid token"
            ]);
        }
        return $next($request);
    }
}
