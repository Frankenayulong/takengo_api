<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CarBooking extends Model
{
    protected $table = 'orders_history';
    public $timestamps = true;
    protected $primaryKey = 'ohid';
    public $incrementing = true;

    public function car(){
        return $this->belongsTo('App\Car', 'cid', 'cid');
    }

    public function customer(){
        return $this->belongsTo('App\Customer', 'uid', 'uid');
    }

    public function transactions(){
        return $this->hasMany('App\CarTransaction', 'ohid', 'ohid');
    }
}
