<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Customer;
class UserController extends Controller
{
    public function show(Request $request){
        $users = Customer::withCount('bookings')
        ->orderBy('first_name', 'asc')
        ->paginate(10);

        return $users;
    }
}
