<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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

    public function last_location(){
        return $this->locations()->orderBy('created_at', 'desc')->first();
    }
}
