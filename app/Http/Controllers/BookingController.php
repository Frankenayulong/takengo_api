<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Car;
use App\Customer;
use App\CarBooking;
use App\CarTransaction;
use App\CarLocation;
use Carbon\Carbon;
use DB;
class BookingController extends Controller
{
    public function index(Request $request, $cid){
        $uid = session('uid');
        $customer = Customer::find($uid);
        $latitude = $request->input('lat', null);
        $longitude = $request->input('long', null);
        if($latitude == null || $longitude == null){
            $car = Car::with('brand');
        }else{
            $car = Car::distance($latitude, $longitude)->with('brand');
        }
        $car = $car->with(['last_location'])->find($cid);
        if(!$car){
            return [
                'status' => 'NOTOK',
                'message' => 'Car not found'
            ];
        }
        $bookings = CarBooking::where('cid', $cid)
        ->where('active', true)
        ->orderBy('active', 'desc')
        ->orderBy('start_date', 'desc')
        ->get();

        return [
            'status' => 'OK',
            'user' => $customer,
            'car' => $car,
            'bookings' => $bookings
        ];
    }

    public function book(Request $request){
        $this->validate($request, [
            'book_end_date' => 'required|date',
            'book_start_date' => 'required|date',
            'cid' => 'required|exists:cars,cid',
            'uid' => 'required|exists:users,uid',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric'
        ]);
        $latitude = $request->input('latitude', null);
        $longitude = $request->input('longitude', null);
        $start_date = $request->input('book_start_date');
        $end_date = $request->input('book_end_date');
        $r_uid = $request->input('uid');
        $cid = $request->input('cid');
        $uid = session('uid');
        if($uid !== $r_uid){
            return [
                'status' => 'AUTHFAILED',
                'message' => 'Authentication Failed'
            ];
        }
        $customer = Customer::find($uid);
        $car = Car::with('last_location')->find($cid);
        if(!$car){
            return [
                "status" => 'NOT OK',
                'message' => 'car not found'
            ];
        }
        $booking = new CarBooking;
        $booking->car()->associate($car);
        $booking->car_price = $car->price;
        $booking->customer()->associate($customer);
        if($latitude != null && $longitude != null){
            $booking->user_lat = $latitude;
            $booking->user_long = $longitude;
        }
        if(count($car->last_location) > 0){
            $booking->car_lat = $car->last_location[0]->lat;
            $booking->car_long = $car->last_location[0]->long;
        }
        $booking->start_date = Carbon::now();
        $booking->end_date = Carbon::now();
        $booking->save();
        return [
            'status' => 'OK',
            'message' => 'Booked',
            'booking' => $booking->ohid
        ];

    }

    public function history(Request $request){
        $uid = session('uid');
        $bookings = CarBooking::with('car')->withCount('transactions')->where('uid', $uid)
        // ->where('active', true)
        ->orderBy('active', 'desc')
        ->orderBy('start_date', 'DESC')
        ->paginate(5);
        return [
            'status' => 'OK',
            'message' => 'Booking history retrieved',
            'bookings' => $bookings
        ];
    }

    public function pay(Request $request, $ohid){
        $booking = CarBooking::with('car')->withCount('transactions')->find($ohid);
        if(!$booking || !$booking->active || $booking->transactions_count > 0 || $booking->uid != session('uid')){
            return [
                'status' => 'NOT OK',
                'message' => 'cannot pay booking'
            ];
        }
        $end = Carbon::parse($booking->end_date);
        $start = Carbon::parse($booking->start_date);
        $days = $end->diffInDays($start);
        $transaction = new CarTransaction;
        $transaction->booking()->associate($booking);
        $transaction->amount = $days * $booking->car_price;
        $transaction->card = 'AUTO';
        $transaction->card_type = 'SYSTEM';
        $transaction->save();
        return [
            'status' => 'OK',
            'message' => 'booking paid'
        ];
    }

    public function cancel(Request $request, $ohid){
        $latitude = $request->input('latitude', null);
        $longitude = $request->input('longitude', null);
        $booking = CarBooking::with('car')->withCount('transactions')->find($ohid);
        if(!$booking || !$booking->active || $booking->transactions_count > 0 || $booking->uid != session('uid')){
            return [
                'status' => 'NOT OK',
                'message' => 'cannot pay booking'
            ];
        }
        DB::transaction(function () use($booking, $latitude, $longitude) {
            $booking->end_date = Carbon::now();
            $booking->active = false;
            $booking->save();
            if($latitude != null && $longitude != null){
                $car = $booking->car;
                $loc = new CarLocation;
                $loc->car()->associate($car);
                $loc->lat = $latitude;
                $loc->long = $longitude;
                $loc->save();
            }
        });
        
        return [
            'status' => 'OK'
        ];
    }
}
