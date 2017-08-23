<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Car;

class CarController extends Controller
{
    public function show(Request $request){
        $latitude = $request->input('lat', null);
        $longitude = $request->input('long', null);
        $radius = $request->input('rad', 5000);
        $car = null;
        if($latitude == null || $longitude == null){
            $car = Car::with('brand')->paginate(10);
        }else{
            $car = Car::get_by_radius($latitude, $longitude, $radius)
            ->orderBy('distance')
            ->paginate(10);
        }
        return $car;
        return [$car->toSql(), $car->getBindings()];
        return response($request->ip());
    }
}
