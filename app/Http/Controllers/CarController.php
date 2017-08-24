<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Car;
use Exception;
use Illuminate\Support\Facades\Storage;

class CarController extends Controller
{
    public function show(Request $request){
        $latitude = $request->input('lat', null);
        $longitude = $request->input('long', null);
        $radius = $request->input('rad', 4000);
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

    public function image(Request $request, $cid){
        $arrContextOptions=[
            "ssl"=>[
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ],
        ];  
        try{
            $car = Car::with(['pictures' => function($q){
                return $q->orderBy('priority', 'desc')->first();
            }])->find($cid);
            if(!$car || count($car->pictures) <= 0){
                $path = asset('/images/system_images/no-image-available.png');
                $path_parts = pathinfo($path);
                $file = file_get_contents($path, true, stream_context_create($arrContextOptions));
                // return [$file];
                // if($file === false){
                //     throw new Exception;
                // }
                
                return response($file, 200)->header('Content-Type', "image/".$path_parts["extension"]);
            }
            $path = asset('/images/cars/' . $cid . '/' . $car->pictures[0]->pic_name);
            $path_parts = pathinfo($path);
            if ($path_parts['extension'] == "css")
            {
                $mime = "text/css";
            }else if($path_parts['extension'] == "svg"){
                $mime = "image/svg+xml";
            }else{
                $mime = "image/".$path_parts['extension'];
            }
                    
            $file = @file_get_contents($path , true, stream_context_create($arrContextOptions));
            if($file === false){
                throw new Exception;
            }
            $response = response($file, 200)->header('Content-Type', $mime);
            return $response;   
        }catch(Exception $e){
            return "whoops";
        }
    }
}
