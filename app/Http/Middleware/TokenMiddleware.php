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
        if($request->header('X-TKNG-UID') != null && $request->header('X-TKNG-TKN') != null && $request->header('X-TKNG-EM') != null){
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
                "message" => "Invalid token"
            ]);
        }
        $customer->makeVisible('token');
        session([
            'uid' => $customer->uid,
            'email' => $customer->email,
            'token' => $customer->token
        ]);
        return $next($request);
    }
}
