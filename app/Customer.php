<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'token', 'password', 'updated_at'
    ];

    protected $table = 'users';
    public $timestamps = true;
    protected $primaryKey = 'uid';
    public $incrementing = true;

    public function bookings(){
        return $this->hasMany('App\CarBooking', 'uid', 'uid');
    }
}
