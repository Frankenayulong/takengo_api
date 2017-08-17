<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CarController extends Controller
{
    public function show(Request $request){
        $loc = geoip()->getLocation();
        return json_encode($loc);
    }
}
