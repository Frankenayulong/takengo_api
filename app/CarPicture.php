<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CarPicture extends Model
{
    protected $table = 'cars_pictures';
    public $timestamps = true;
    protected $primaryKey = 'cpid';
    public $incrementing = true;

    public function car(){
        return $this->belongsTo('App\Car', 'cid', 'cid');
    }
}
