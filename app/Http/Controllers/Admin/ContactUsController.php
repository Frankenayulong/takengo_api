<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ContactUs;
class ContactUsController extends Controller
{
    public function show(Request $request){
        $contacts = ContactUs::orderBy('resolved', 'asc')
        ->orderBy('created_at', 'desc')
        ->paginate(10);
        return $contacts;
    }
}
