<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Cookie\CookieJar;
use Illuminate\Contracts\Encryption\DecryptException;
use App\Customer;
use Socialite;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

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

    public function login(Request $request){
        $this->validate($request, [
            'email' => 'required|email|max:255|exists:users,email',
            'fb_uid' => 'required|string|exists:users,fb_uid'
        ]);
        $email = $request->input('email');
        $fb_uid = $request->input('fb_uid');
        $ip = request()->ip();

        $customer = Customer::where('email', $email)->where('fb_uid', $fb_uid)->first();
        $customer->token = str_random(16);
        $customer->last_ip = $ip;
        $customer->save();
        if(!$customer){
            return response([
                'status' => 'NOTOK',
                'message' => 'Invalid Credentials'
            ]);
        }
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

    public function remove_cookie(CookieJar $cookieJar, Request $request){
        $cookie = $cookieJar->forget('tng_token', '/', config('session.domain'));
        return response("done", 200)
        ->cookie($cookie);
    }

    public function get_profile(Request $request){
        return response("ok", 200);
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

    public function providerCallback(Request $request)
    {
        $user = Socialite::driver('google')->user();
        $provider = session('oauthprv');
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
        return redirect()->away((is_null(parse_url($callback, PHP_URL_HOST)) ? '//' : '').$callback.'?new_user='.$response->new_user);
    }
}
