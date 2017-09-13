<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Car;
use App\CarBrand;
class CarController extends Controller
{
    public function show(Request $request){
        $car = Car::with('brand')->withCount(['orders as active_order' => function($q){
            return $q->whereDate('start_date', '>=', Carbon::today()->toDateString())->where('active', true);
        }, 'orders as inactive_order' => function($q){
            return $q->whereDate('start_date', '>=', Carbon::today()->toDateString())->where('active', false);
        }])
        ->orderBy('active_order_count', 'desc')
        ->orderBy('inactive_order_count', 'desc')
        ->paginate(10);
        return $car;
    }

    public function brands(Request $request){
        $brands = CarBrand::get();
        return $brands;
    }
}
