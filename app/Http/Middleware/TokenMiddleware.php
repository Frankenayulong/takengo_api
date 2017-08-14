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
        $uid = session('uid');
        $email = $request->input('email');
        $token = $request->cookie('tng_token');
        if(!$token || !$email){
            return response([
                "status" => "NOTOK",
                "message" => "Invalid Token"
            ]);
        }

        try{
            $token = decrypt($token);
            $token = (object)$token;
            $customer = Customer::where('token', $token->token)->where('email', $email)->first();
            if(!$customer || $token->uid != $customer->uid || $token->uid != $uid){
                return response([
                    "status" => 'NOT OK',
                    "message" => "Invalid token"
                ]);
            }

            return response([
                "status" => "OK",
                "message" => "Token Authorized"
            ]);

        }catch(DecryptException $e){
            return response([
                "status" => 'NOT OK',
                "message" => "Invalid token"
            ]);
        }
        return $next($request);
    }
}
