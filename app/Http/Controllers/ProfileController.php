<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use Illuminate\Support\Facades\DB;
use App\Classes\Slim;

class ProfileController extends Controller
{
    public function update(Request $request){
        return session('uid');
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'gender' => 'required|in:M,F',
            'phone' => 'required|min:9|max:10',
            'birth_date' => 'nullable|date',
            'address' => 'required',
            'suburb' => 'required',
            'state' => 'required',
            'post_code' => 'nullable'
        ]);

        $uid = session('uid');
        $customer = Customer::find($uid);
        $customer->first_name = $request->first_name;
        $customer->last_name = $request->last_name;
        $customer->gender = $request->gender;
        $customer->phone = $request->phone;
        $customer->birth_date = $request->birth_date;
        $customer->address = $request->address;
        $customer->suburb = $request->suburb;
        $customer->state = $request->state;
        $customer->post_code = $request->post_code;
        $customer->save();        
        return response($customer);
    }

    public function upload(Request $request, $uid){
        // $uid = session('uid');
        return session('uid');
        $customer = Customer::findOrFail($uid);
    
        if ( $request->picture )
        {
            // Pass Slim's getImages the name of your file input, and since we only care about one image, postfix it with the first array key
            $image = Slim::getImages('picture')[0];
    
            // Grab the ouput data (data modified after Slim has done its thing)
            if ( isset($image['output']['data']) )
            {
                // Original file name
                $name = $image['output']['name'];
    
                // Base64 of the image
                $data = $image['output']['data'];
    
                // Server path
                $path = base_path() . '/public/images/user/'. $uid . '/documents' . '/';
    
                // Save the file to the server
                $file = Slim::saveFile($data, $name, $path);
    
                // Get the absolute web path to the image
                $imagePath = asset('/images/user/'. $uid . '/documents' . '/' . $file['name']);
    
                $customer->driver_license_picture = $file['name'];
                $customer->save();
                return[
                  $request, $customer, $imagePath
                ];
            }
        }
    }
}
