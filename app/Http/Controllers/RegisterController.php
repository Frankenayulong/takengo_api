<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use Illuminate\Contracts\Encryption\DecryptException;

class RegisterController extends Controller
{
    public function register(Request $request){
        $this->validate($request, [
            'email' => 'required|unique:users|max:255',
            'password' => 'required|min:8|confirmed'
        ]);
        $email = $request->input('email');
        $ip = request()->ip();
        $customer = new Customer;
        $customer->token = str_random(16);
        $customer->email = $email;
        $customer->last_ip = $ip;
        $customer->save();
        $encryptedToken = encrypt([
            "uid"=>$customer->uid, 
            "token"=>$customer->token
        ]);
        session([
            'uid' => $customer->uid,
            'email' => $customer->email,
            'token' => $encryptedToken
        ]);
        return response([
            'status' => 'OK',
            'user' => $customer
        ])
        ->header('Content-Type', 'application/json')
        ->cookie('tng_token', $encryptedToken, 2628000, '/', config('session.domain'), false, true);
    }

    public function error(Request $request){
        $email = $request->input('email');
        $token = $request->session()->get('token');
        if(!$token){
            return response('error');
        }
        try{
            $token = (object)decrypt($token);
        }catch(DecryptException $e){
            return response('decrypt fail');
        }

        $user = Customer::where('email', $email)
        ->where('token', $token->token)
        ->select('uid', 'token')
        ->first();

        if(!$user){
            //ERROR
            return response($email);
        }
        $user->delete();
        return response('done');
    }
}
