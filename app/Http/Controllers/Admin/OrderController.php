<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\CarBooking;
use App\CarLocation;
class OrderController extends Controller
{
    public function show(Request $request){
        $bookings = CarBooking::with('car', 'customer')
        ->withCount('transactions')
        ->orderBy('start_date', 'desc')
        ->paginate(10);

        return $bookings;
    }

    public function details(Request $request, $ohid){
        $booking = CarBooking::with('car.pictures', 'customer')->find($ohid);
        $locations = CarLocation::where('cid', $booking->car->cid)
        ->where('created_at', '>', $booking->start_date)
        ->where('created_at', '<', $booking->end_date)->get();
        $before_location = CarLocation::where('cid', $booking->car->cid)
        ->where('created_at', '<', $booking->start_date)->orderBy('created_at', 'desc')->first();
        return [
            'booking' => $booking,
            'locations' => $locations,
            'before_location' => $before_location,
            'last_location' => $locations->last()
        ];
    }
}
