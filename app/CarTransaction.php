<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CarTransaction extends Model
{
    protected $table = 'transactions_history';
    public $timestamps = true;
    protected $primaryKey = 'thid';
    public $incrementing = true;

    public function booking(){
        return $this->belongsTo('App\CarBooking', 'ohid', 'ohid');
    }
}
