<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Cookie\CookieJar;
use Illuminate\Contracts\Encryption\DecryptException;

class LoginController extends Controller
{
    public function check_token(Request $request){
        if($request->cookie('tng_token') === null){
            return response('nocookie', 200);
        }
        try{
            return $request->cookie('tng_token');
            $token = decrypt($request->cookie('tng_token'));
            $token = (object)$token;
            return $request->cookie('tng_token');
        }catch(DecryptException $e){
            return $request->cookie('tng_token');
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
