<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Location;
class CarController extends Controller
{
    public function show(Request $request){
        $position = Location::get();
        return json_encode($position);
    }
}
