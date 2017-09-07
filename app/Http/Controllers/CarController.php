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
        $car_type = $request->input('type', '');
        $price_range = $request->input('price', '');
        $radius = $request->input('rad', 10);
        $radius *= 1000;
        $sort = $request->input('sort', '');
        $price_range = explode(' ', $price_range);
        $price_min = -1;
        $price_max = -1;
        if(count($price_range) > 1){
            $price_min = $price_range[0];
            $price_max = $price_range[1];
            if($price_max == 0){
                $price_max = 9000000;
            }
        }
        $sort = explode(' ', $sort);
        $sort_by = '';
        $sort_dir = 'asc';
        if(count($sort) > 1){
            $sort_by = $sort[0];
            if($sort[1] == 'asc'){
                $sort_dir = 'asc';
            }else{
                $sort_dir = 'desc';
            }
        }
        $car = null;
        if($latitude == null || $longitude == null){
            $car = Car::with('brand');
        }else{
            $car = Car::get_by_radius($latitude, $longitude, $radius);
        }
        if(strlen($car_type) > 0){
            $car->where('car_types', $car_type);
        }
        if($price_min !== -1 && $price_max !== -1){
            $car->where(function($q) use ($car, $price_min, $price_max){
                $car
                ->where('price', '>=', $price_min)
                ->where('price', '<=', $price_max);
            });
            
        }
        if(strlen($sort_by) > 0){
            $car->orderBy($sort_by, $sort_dir);
        }else{
            if($latitude !== null && $longitude !== null){
                $car->orderBy('distance');
            }else{
                $car->orderBy('name');
            }
        }
        $car = $car->paginate(10);
        
        return $car;
    }

    public function detail(Request $request, $cid){
        $latitude = $request->input('lat', null);
        $longitude = $request->input('long', null);
        if($latitude == null || $longitude == null){
            $car = Car::with('brand');
        }else{
            $car = Car::distance($latitude, $longitude)->with('brand');
        }
        $car = $car->with(['pictures' => function($q){
            return $q->orderBy('priority', 'desc')->get();
        }, 'last_location'])->find($cid);
        if(!$car){
            return [
                "status" => "NOT OK",
                "message" => "Car not found"
            ];
        }
        return [
            "status" => 'OK',
            'car' => $car
        ];
    }

    public function image_by_name(Request $request, $cid, $name){
        $arrContextOptions=[
            "ssl"=>[
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ],
        ];  
        try{
            $car = Car::find($cid);
            if(!$car){
                throw new Exception;
            }
            $path = asset('/images/cars/' . $cid . '/' . $name);
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
            $path = asset('/images/system_images/no-image-available.png');
            $path_parts = pathinfo($path);
            $file = file_get_contents($path, true, stream_context_create($arrContextOptions));
            
            return response($file, 200)->header('Content-Type', "image/".$path_parts["extension"]);
        }
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
