<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ContactUs;
class ContactUsController extends Controller
{
    public function create(Request $request){
        $this->validate($request, [
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|min:9|max:10',
            'content' => 'required'
        ]);
        $contact = new ContactUs;
        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->phone = $request->phone;
        $contact->content = $request->content;
        $contact->save();
        return [
            'status' => 'OK',
            'message' => 'Query received'
        ];
    }
}
