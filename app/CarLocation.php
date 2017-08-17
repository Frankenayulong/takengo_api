<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CarLocation extends Model
{
    protected $table = 'cars_locations';
    public $timestamps = true;
    protected $primaryKey = 'clid';
    public $incrementing = true;

    public function car(){
        return $this->belongsTo('App\Car', 'cid', 'cid');
    }
}
