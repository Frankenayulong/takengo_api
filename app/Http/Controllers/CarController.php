<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Location;
class CarController extends Controller
{
    public function show(Request $request){
        $position = Location::get('192.168.1.1');
        return json_encode($position);
    }
}
