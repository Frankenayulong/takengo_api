<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactUs extends Model
{
    protected $table = 'contact_us';
    public $timestamps = true;
    protected $primaryKey = 'cuid';
    public $incrementing = true;
}