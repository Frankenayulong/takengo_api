<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\NewsletterEmail;
class NewsletterController extends Controller
{
    public function register(Request $request){
        $this->validate($request, [
            'email' => 'required|email|unique:newsletter_emails,email'
        ]);
        $newsletter_email = new NewsletterEmail;
        $newsletter_email->email = $request->email;
        $newsletter_email->save();
        return [
            'status' => 'OK',
            'message' => 'Email registered'
        ];
    }
}
