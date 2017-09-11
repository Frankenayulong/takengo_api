<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\CarBooking;
class OrderController extends Controller
{
    public function show(Request $request){
        $bookings = CarBooking::with('car', 'customer')
        ->withCount('transactions')
        ->orderBy('start_date', 'desc')
        ->paginate(10);

        return $bookings;
    }
}
