<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CarBrand extends Model
{
    protected $table = 'car_brands';
    public $timestamps = true;
    protected $primaryKey = 'cbid';
    public $incrementing = true;

    public function cars(){
        return $this->hasMany('App\Car', 'cbid', 'cbid');
    }
}
