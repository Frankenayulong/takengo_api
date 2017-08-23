<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Car;

class CarController extends Controller
{
    public function show(Request $request){
        $car = Car::get_by_radius(-37.8230974, 144.9541606, 5000);
        return $car->orderBy('distance')->paginate(10);
        return [$car->toSql(), $car->getBindings()];
        return response($request->ip());
    }
}
