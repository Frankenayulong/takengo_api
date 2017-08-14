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
        $customer_check = Customer::where('email', $email)->count();
        if($customer_check > 0){
            return response([
                'status' => 'NOT OK',
                'message' => 'User Already Exists'
            ]);
        }
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

    public function uid(Request $request){
        $this->validate($request, [
            'email' => 'required|exists:users|max:255',
            'fb_uid' => 'required|unique:users'
        ]);
        try{
            $uid = $request->input('uid');
            $fb_uid = $request->input('fb_uid');
            $token = decrypt($request->cookie('tng_token'));
            $token = (object)$token;
            if($token->uid != $uid){
                return [
                    "status" => 'NOT OK',
                    "message" => "Invalid token"
                ];
            }
            $customer = Customer::find($request->input('uid'))->where('token', $token->token);
            $customer->fb_uid = $fb_uid;
            $customer->save();
            return [
                "status" => "OK",
                "message" => "Customer FBUID updated"
            ];
        }catch(DecryptException $e){
            return [
                "status" => 'NOT OK',
                "message" => "Invalid token"
            ];
        }
        
    }

    public function vendor(Request $request){
        $this->validate($request, [
            'email' => 'required|email|max:255',
            'fb_uid' => 'required|unique:users'
        ]);
        $email = $request->input('email');
        $fb_uid = $request->input('fb_uid');
        $ip = request()->ip();

        $customer = new Customer;
        $customer->fb_uid = $fb_uid;
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
}
