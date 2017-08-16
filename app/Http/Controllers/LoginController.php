<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Cookie\CookieJar;
use Illuminate\Contracts\Encryption\DecryptException;
use App\Customer;
use Socialite;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function check_token(Request $request){
        if($request->cookie('tng_token') === null){
            return response('nocookie', 200);
        }
        try{
            $token_raw = decrypt($request->cookie('tng_token'));
            $token = (object)$token_raw;
            if(!property_exists($token, 'uid') || ! property_exists($token, 'token') || !property_exists($token, 'email')){
                return response([
                    "status" => 'NOT OK',
                    "message" => "Invalid token"
                ]);
            }
            $customer = Customer::where('uid', $token->uid)->where('token', $token->token)->where('email', $token->email)->first();
            if(!$customer){
                return response([
                    "status" => 'NOT OK',
                    "message" => "Invalid token"
                ]);
            }
            session([
                'uid' => $customer->uid,
                'email' => $customer->email,
                'token' => $customer->token
            ]);
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
    }

    public function login(Request $request){
        $this->validate($request, [
            'email' => 'required|email|max:255|exists:users,email',
            'password' => 'required|string'
        ]);
        $email = $request->input('email');
        $password = $request->input('password');
        $ip = request()->ip();

        $customer = Customer::where('email', $email)->first();
        if(!$customer){
            return response([
                'status' => 'NOTOK',
                'message' => 'Invalid Credentials'
            ]);
        }
        if(!Hash::check($password, $customer->makeVisible('password')->password)){
            return response([
                'status' => 'NOTOK',
                'message' => 'Invalid Credentials'
            ]);
        }
        $customer->makeHidden('password');
        $customer->token = str_random(16);
        $customer->last_ip = $ip;
        $customer->save();

        $encryptedToken = encrypt([
            "uid"=>$customer->uid, 
            "token"=>$customer->token,
            "email"=>$customer->email
        ]);
        return response([
            'status' => 'OK',
            'user' => $customer
        ])
        ->header('Content-Type', 'application/json')
        ->cookie('tng_token', $encryptedToken, 2628000, '/', config('session.domain'), false, true);
    }

    public function remove_cookie(CookieJar $cookieJar, Request $request){
        $cookie = $cookieJar->forget('tng_token', '/', config('session.domain'));
        return response("done", 200)
        ->cookie($cookie);
    }

    public function get_profile(Request $request){
        $uid = session('uid');
        $customer = Customer::find($uid);
        return response([
            'status' => 'OK',
            'user' => $customer
        ], 200);
    }
    
    public function providerRedirect(Request $request, $provider){
        if($provider != 'google' && $provider != 'facebook'){
            return back()->with(['errmsg' => 'Invalid provider']);
        }
        $callback_url = $request->server('HTTP_REFERER');
        if(strlen($callback_url) <= 0){
            $callback_url = 'http://takengo.dev';
        }
        session([
            'oauthprv'=> $provider,
            'oauthcb' => $callback_url
        ]);
        return Socialite::driver($provider)->redirect();
    }

    public function providerCallback(CookieJar $cookieJar, Request $request)
    {
        $provider = session('oauthprv');
        $user = Socialite::driver($provider)->user();
        $callback = session('oauthcb');
        $name = $user->getName();
        $parts = explode(" ", $name);
        $last_name = array_pop($parts);
        $first_name = implode(" ", $parts);

        $client = new Client(); //GuzzleHttp\Client
        $result = $client->post(route('vendor.register'), [
            'form_params' => [
                'email' => $user->getEmail(),
                'first_name' => $first_name, 
                'last_name' => $last_name,
                'vendor' => $provider,
                'callback' => $callback
            ]
        ]);
        $response = json_decode((string)$result->getBody());
        $cookie = $cookieJar->make('tng_token', $response->token, 2628000, '/', config('session.domain'), false, true);
        return redirect()->away((is_null(parse_url($callback, PHP_URL_HOST)) ? '//' : '').$callback)->withCookie($cookie);
    }
}
