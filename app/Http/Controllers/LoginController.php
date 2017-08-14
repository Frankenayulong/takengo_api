<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Cookie\CookieJar;
use Illuminate\Contracts\Encryption\DecryptException;
use App\Customer;

class LoginController extends Controller
{
    public function check_token(Request $request){
        if($request->cookie('tng_token') === null){
            return response('nocookie', 200);
        }
        $this->validate($request, [
            'email' => 'required|exists:users|max:255'
        ]);
        try{
            $email = $request->input('email');
            $token = decrypt($request->cookie('tng_token'));
            $token = (object)$token;
            $customer = Customer::where('token', $token->token)->where('email', $email)->first();
            if(!$customer || $token->uid != $customer->uid){
                return [
                    "status" => 'NOT OK',
                    "message" => "Invalid token"
                ];
            }
            session(['uid' => $customer->uid]);
            return [
                "status" => "OK",
                "message" => "Token Authorized"
            ];
        }catch(DecryptException $e){
            return [
                "status" => 'NOT OK',
                "message" => "Invalid token"
            ];
        }
    }

    public function remove_cookie(CookieJar $cookieJar, Request $request){
        $cookie = $cookieJar->forget('tng_token', '/', config('session.domain'));
        return response("done", 200)
        ->cookie($cookie);
    }

    public function get_profile(Request $request){
        return response("ok", 200);
    }
    
}
