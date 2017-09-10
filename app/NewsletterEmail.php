<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewsletterEmail extends Model
{
    protected $table = 'newsletter_emails';
    public $timestamps = true;
    protected $primaryKey = 'neid';
    public $incrementing = true;
}
