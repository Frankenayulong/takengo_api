<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Car;
use App\Customer;

class BookingController extends Controller
{
    public function index(Request $request, $cid){
        $uid = session('uid');
        $customer = Customer::find($uid);

        $car = Car::find($cid);
        if(!$car){
            return [
                'status' => 'NOTOK',
                'message' => 'Car not found'
            ];
        }

        return [
            'status' => 'OK',
            'user' => $customer,
            'car' => $car
        ];
    }
}
