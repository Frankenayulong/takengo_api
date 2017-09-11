<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
class AdminController extends Controller
{
    public function show(Request $request){
        $admins = User::orderBy('first_name', 'asc')
        ->paginate(10);

        return $admins;
    }
}
