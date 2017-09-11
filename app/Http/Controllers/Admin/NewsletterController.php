<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\NewsletterEmail;
class NewsletterController extends Controller
{
    public function show(Request $request){
        $emails = NewsletterEmail::orderBy('email', 'asc')
        ->paginate(10);
        return $emails;
    }
}
