<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function register(Request $request){
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|unique:users|max:255',
            'password' => 'required|min:8|confirmed'
        ]);
        $first_name = $request->input('first_name');
        $last_name = $request->input('last_name');
        $email = $request->input('email');
        $password = $request->input('password');
        $ip = request()->ip();
        $customer_check = Customer::where('email', $email)->count();
        if($customer_check > 0){
            return response()->json([
                'status' => 'NOT OK',
                'message' => 'User Already Exists'
            ]);
        }
        $customer = new Customer;
        $customer->first_name = $first_name;
        $customer->last_name = $last_name;
        $customer->token = str_random(16);
        $customer->email = $email;
        $customer->last_ip = $ip;
        $customer->password = Hash::make($password);
        $customer->vendor = 'takengo';
        $customer->save();
        $encryptedToken = encrypt([
            "uid"=>$customer->uid, 
            "token"=>$customer->token,
            "email"=>$customer->email
        ]);
        return response()->json([
            'status' => 'OK',
            'user' => $customer
        ])
        ->header('Content-Type', 'application/json')
        ->cookie('tng_token', $encryptedToken, 2628000, '/', config('session.domain'), false, true);
    }

    public function vendor(Request $request){
        $this->validate($request, [
            'email' => 'required|email|max:255',
            'vendor' => 'required|in:google,facebook'
        ]);
        $email = $request->input('email');
        $first_name = $request->input('first_name');
        $last_name = $request->input('last_name');
        $vendor = $request->input('vendor');
        $ip = request()->ip();
        $callback = $request->input('callback', 'https://takengo.dev');
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
            "token"=>$customer->token,
            "email"=>$customer->email
        ]);
        
        return response()->json([
            'status' => 'OK',
            'new_user' => $new_user,
            'token' => $encryptedToken
        ]);
    }
}
