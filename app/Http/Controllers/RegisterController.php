<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Cookie\CookieJar;

class RegisterController extends Controller
{
    public function register(Request $request){
        $this->validate($request, [
            'email' => 'required|unique:users|max:255',
            'password' => 'required|min:8|confirmed'
        ]);
        $email = $request->input('email');
        $password = $request->input('password');
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
        $customer->password = Hash::make($password);
        $customer->save();
        $encryptedToken = encrypt([
            "uid"=>$customer->uid, 
            "token"=>$customer->token
        ]);
        session([
            'uid' => $customer->uid
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
            $fb_uid = $request->input('fb_uid');
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

    public function vendor(CookieJar $cookieJar, Request $request){
        $this->validate($request, [
            'email' => 'required|email|max:255',
            'vendor' => 'required|in:google,facebook'
        ]);
        $email = $request->input('email');
        $first_name = $request->input('first_name');
        $last_name = $request->input('last_name');
        $vendor = $request->input('vendor');
        $ip = request()->ip();
        $callback = $request->input('callback', 'http://takengo.dev');
        $new_user = false;

        $customer = Customer::where('email', $email)->first();
        if(!$customer){
            $new_user = true;
            $customer = new Customer;
            $customer->token = str_random(16);
            $customer->email = $email;
            $customer->vendor = $vendor;
            $customer->first_name = $first_name;
            $customer->password = Hash::make(str_random(32));
            $customer->last_name = $last_name;
            $customer->last_ip = $ip;
            $customer->save();
        }
        $encryptedToken = encrypt([
            "uid"=>$customer->uid, 
            "token"=>$customer->token
        ]);
        session([
            'uid' => $customer->uid
        ]);
        $cookie = $cookieJar->make('tng_token', $encryptedToken, 2628000, '/', config('session.domain'), false, true);
        return response([
            'status' => 'OK',
            'new_user' => $new_user
        ], 200)->withCookie($cookie);
    }
}
