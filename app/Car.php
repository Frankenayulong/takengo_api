<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Car extends Model
{
    protected $table = 'cars';
    public $timestamps = true;
    protected $primaryKey = 'cid';
    public $incrementing = true;

    public function brand(){
        return $this->belongsTo('App\CarBrand', 'cbid', 'cbid');
    }

    public function locations(){
    	return $this->hasMany('App\CarLocation', 'cid', 'cid');
    }

    public function pictures(){
    	return $this->hasMany('App\CarPicture', 'cid', 'cid');
    }

    public function last_location(){
        return $this->locations()->orderBy('created_at', 'desc')->take(1);
    }

    public function orders(){
        return $this->hasMany('App\CarBooking', 'cid', 'cid');
    }

    public static function get_by_radius($user_lat, $user_long, $radius){
        return Car::with(['brand'])
        ->withCount(['orders as active_order' => function($q){
            return $q->where('active', true);
        }])
        ->join('cars_locations as l1', 'cars.cid', '=', 'l1.cid')
        ->leftJoin('cars_locations as l2', function($join)
        {
            $join->on('cars.cid', '=', 'l2.cid');
            $join->on('l1.created_at','<', 'l2.created_at');
       
        }, 'left outer')
        ->selectRaw("earth_distance(ll_to_earth(l1.lat, l1.long), ll_to_earth(?, ?)) AS distance, cars.*, l1.lat, l1.long", [$user_lat, $user_long])
        ->where("l2.clid", null)
        ->whereRaw("earth_box(ll_to_earth(?, ?), ?) @> ll_to_earth(l1.lat, l1.long)", [$user_lat, $user_long, $radius]);
    }

    public static function distance($user_lat, $user_long){
        return Car::join('cars_locations as l1', 'cars.cid', '=', 'l1.cid')
        ->leftJoin('cars_locations as l2', function($join)
        {
            $join->on('cars.cid', '=', 'l2.cid');
            $join->on('l1.created_at','<', 'l2.created_at');
       
        }, 'left outer')
        ->selectRaw("earth_distance(ll_to_earth(l1.lat, l1.long), ll_to_earth(?, ?)) AS distance, cars.*", [$user_lat, $user_long])
        ->where("l2.clid", null);
    }
}
