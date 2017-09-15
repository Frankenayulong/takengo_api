<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Car;
use App\CarBrand;
use App\CarPicture;
use App\CarLocation;
use App\Classes\Slim;

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

    public function single(Request $request, $cid){
        $car = Car::with('pictures')->find($cid);
        if(!$car){
            return [
                'status' => 'NOT OK',
            ];
        }else{
            return [
                'status' => 'OK',
                'car' => $car
            ];
        }
    }

    public function create(Request $request){
        $this->validate($request, [
            'name' => 'required',
            'cbid' => 'required|exists:car_brands,cbid',
            'model' => 'required',
            'release_year' => 'required|digits:4',
            'car_types' => 'required|in:SEDAN,SUV,HATCHBACK,SPORT',
            'transition_mode' => 'required|in:AUTO,MANUAL',
            'price' => 'required|numeric',
            'capacity' => 'nullable|numeric',
            'doors' => 'nullable|numeric',
            'large_bags' => 'nullable|numeric',
            'small_bags' => 'nullable|numeric',
            'air_conditioned' => 'required|boolean',
            'fuel_policy' => 'nullable',
            'unlimited_mileage' => 'required|boolean',
            'limit_mileage' => 'nullable|numeric'
        ]);
        $car = new Car;
        $car->name = $request->name;
        $car->cbid = $request->cbid;
        $car->model = $request->model;
        $car->release_year = $request->release_year;
        $car->car_types = $request->car_types;
        $car->transition_mode = $request->transition_mode;
        $car->price = $request->price;
        $car->capacity = $request->capacity;
        $car->doors = $request->doors;
        $car->large_bags = $request->large_bags;
        $car->small_bags = $request->small_bags;
        $car->air_conditioned = $request->air_conditioned;
        $car->fuel_policy = $request->fuel_policy;
        $car->unlimited_mileage = $request->unlimited_mileage;
        $car->limit_mileage = $request->limit_mileage;
        $car->save();
        return [
            "status" => 'OK',
            "message" => 'Car saved',
            'car' => $car
        ];
    }

    public function change_location(Request $request, $cid){
        $car = Car::find($cid);
        if(!$car){
            return response()->json([
                'status' => 'NOT OK'
            ]);
        }
        $latitude = $request->input('latitude', null);
        $longitude = $request->input('longitude', null);
        if($latitude == null || $longitude == null){
            return response()->json([
                'status' => 'NOT OK'
            ]);
        }
        $loc = new CarLocation;
        $loc->car()->associate($car);
        $loc->lat = $latitude;
        $loc->long = $longitude;
        $loc->save();
        return response()->json([
            'status' => 'OK'
        ]);
    }

    public function upload(Request $request, $cid){
        
        $car = Car::findOrFail($cid);
        
        if ( $request->picture )
        {
            // Pass Slim's getImages the name of your file input, and since we only care about one image, postfix it with the first array key
            $image = Slim::getImages('picture')[0];
    
            // Grab the ouput data (data modified after Slim has done its thing)
            if ( isset($image['output']['data']) )
            {
                // Original file name
                $name = $image['output']['name'];
    
                // Base64 of the image
                $data = $image['output']['data'];
    
                // Server path
                $path = base_path() . '/public/images/cars/'. $cid;
    
                // Save the file to the server
                $file = Slim::saveFile($data, $name, $path);
    
                // Get the absolute web path to the image
                $imagePath = asset('/images/cars/'. $cid . '/' . $file['name']);
    
                $carPicture = new CarPicture;
                $carPicture->pic_name = $file['name'];
                $carPicture->format = pathinfo($imagePath)['extension'];
                $carPicture->original_full_path = $imagePath;
                $carPicture->car()->associate($car);
                $carPicture->save();

                return response()->json($carPicture);
            }
        }
    }
}
