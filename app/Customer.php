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
        'token', 'fb_uid',
    ];

    protected $table = 'users';
    public $timestamps = true;
    protected $primaryKey = 'uid';
    public $incrementing = true;
}