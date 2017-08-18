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
        $uid = '';
        $token = '';
        $email = '';
        if(!$request->session()->exists('uid') || !$request->session()->exists('email') || !$request->session()->exists('token')){
            $uid = $request->header('X-TKNG-UID');
            $token = $request->header('X-TKNG-TKN');
            $email = $request->header('X-TKNG-EM');
        }else{
            $uid = session('uid');
            $email = session('email');
            $token = session('token');
        }
        
        $customer = Customer::where('uid', $uid)->where('token', $token)->where('email', $email)->first();
        if(!$customer){
            return response()->json([
                "status" => 'NOT OK',
                "message" => "Invalid tokend",
                "uid" => $customer->uid,
                "email" => $customer->email,
                "token" => $customer->token,
                'first_name' => strlen($customer->first_name) > 0 ? $customer->first_name : 'My Profile'
            ]);
        }
        session([
            'uid' => $customer->uid,
            'email' => $customer->email,
            'token' => $customer->token
        ]);
        return $next($request);
    }
}
