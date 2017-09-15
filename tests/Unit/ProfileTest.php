<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Customer;
use Carbon\Carbon;
class ProfileTest extends TestCase
{

    private function createUser($email){
        Customer::where('email', $email)->delete();
        $user = new Customer;
        $user->first_name = 'Veronica';
        $user->last_name = 'Ong';
        $user->email = $email;
        $user->password = bcrypt('veronicaong');
        $user->last_ip = '::1';
        $user->save();
        return $user;
    }

    private function deleteUser($user){
        $user->delete();
    }

    private function login($user){
        $response = $this->json('POST', '/api/login', 
        [
            'email' => $user->email,
            'password' => 'veronicaong'
        ]);
        if($response->status() == 422){
            echo $user->email;
        }
        $response->assertStatus(200);
        $response->assertJson([
            'status' => 'OK'
        ]);
        $data = $response->getData();
        $token = $data->token;
        $email = $data->email;
        $uid = $data->uid;
        return [
            'X-TKNG-UID' => $uid,
            'X-TKNG-TKN' => $token,
            'X-TKNG-EM' => $email
        ];
    }

    /**
     * @group profile
     */
    public function testNotAuthenticatedProfile(){
        $email = str_random(20) . '@' . str_random(5) . '.' . 'com';
        $user = $this->createUser($email);
        $header = $this->login($user);
        $response = $this->json('POST', '/api/profile', [], []);
        $response->assertStatus(200);
        $response->assertJson([
            "status" => 'NOT OK',
            "message" => "Invalid token"
        ]);
        $this->deleteUser($user);
    }

    /**
     * @group profile
     */
     public function testAuthenticatedProfile(){
        $email = str_random(20) . '@' . str_random(5) . '.' . 'com';
        $user = $this->createUser($email);
        $header = $this->login($user);
        $response = $this->json('POST', '/api/profile', [], $header);
        $response->assertStatus(200);
        $response->assertJson([
            "status" => 'OK'
        ]);
        $data = $response->getData();
        $this->assertTrue($data->user->uid == $user->uid);
        $this->deleteUser($user);
    }

    /**
     * @group profile
     */
     public function testNotAuthenticatedProfileUpdate(){
        $email = str_random(20) . '@' . str_random(5) . '.' . 'com';
        $user = $this->createUser($email);
        $header = $this->login($user);
        $response = $this->json('PUT', '/api/profile/edit', [
            'first_name' => 'Veronica',
            'last_name' => 'Ong',
            'gender' => 'F',
            'phone' => '0416842836',
            'address' => 'Why so important',
            'suburb' => 'Not really',
            'state' => 'VIC',
            'post_code' => '3000'
        ], []);
        $response->assertStatus(200);
        $response->assertJson([
            "status" => 'NOT OK',
            "message" => "Invalid token"
        ]);
        $this->deleteUser($user);
    }

    /**
     * @group profile
     */
     public function testAuthenticatedProfileUpdateSuccess(){
        $email = str_random(20) . '@' . str_random(5) . '.' . 'com';
        $user = $this->createUser($email);
        $header = $this->login($user);
        $body = [
            'first_name' => 'Vero',
            'last_name' => 'Onggoro',
            'gender' => 'F',
            'phone' => '0416842836',
            'address' => 'Why so important',
            'suburb' => 'Not really',
            'state' => 'VIC',
            'post_code' => '3000'
        ];
        $response = $this->json('PUT', '/api/profile/edit', $body, $header);
        $response->assertStatus(200);
        $data = $response->getData();
        $body = (object)$body;
        $this->assertTrue($data->first_name == $body->first_name);
        $this->assertTrue($data->last_name == $body->last_name);
        $this->assertTrue($data->gender == $body->gender);
        $this->assertTrue($data->phone == $body->phone);
        $this->assertTrue($data->address == $body->address);
        $this->assertTrue($data->suburb == $body->suburb);
        $this->assertTrue($data->state == $body->state);
        $this->assertTrue($data->post_code == $body->post_code);
        $this->deleteUser($user);
    }

    /**
     * @group profile
     */
     public function testAuthenticatedProfileUpdateMissingFirstName(){
        $email = str_random(20) . '@' . str_random(5) . '.' . 'com';
        $user = $this->createUser($email);
        $header = $this->login($user);
        $body = [
            'first_name' => '',
            'last_name' => 'Onggoro',
            'gender' => 'F',
            'phone' => '0416842836',
            'address' => 'Why so important',
            'suburb' => 'Not really',
            'state' => 'VIC',
            'post_code' => '3000'
        ];
        $response = $this->json('PUT', '/api/profile/edit', $body, $header);
        $response->assertStatus(422);
        $this->deleteUser($user);
    }

    /**
     * @group profile
     */
     public function testAuthenticatedProfileUpdateMissingLastName(){
        $email = str_random(20) . '@' . str_random(5) . '.' . 'com';
        $user = $this->createUser($email);
        $header = $this->login($user);
        $body = [
            'first_name' => 'Vero',
            'last_name' => '',
            'gender' => 'F',
            'phone' => '0416842836',
            'address' => 'Why so important',
            'suburb' => 'Not really',
            'state' => 'VIC',
            'post_code' => '3000'
        ];
        $response = $this->json('PUT', '/api/profile/edit', $body, $header);
        $response->assertStatus(422);
        $this->deleteUser($user);
    }

    /**
     * @group profile
     */
     public function testAuthenticatedProfileUpdateMissingGender(){
        $email = str_random(20) . '@' . str_random(5) . '.' . 'com';
        $user = $this->createUser($email);
        $header = $this->login($user);
        $body = [
            'first_name' => 'Vero',
            'last_name' => 'Onggoro',
            'gender' => '',
            'phone' => '0416842836',
            'address' => 'Why so important',
            'suburb' => 'Not really',
            'state' => 'VIC',
            'post_code' => '3000'
        ];
        $response = $this->json('PUT', '/api/profile/edit', $body, $header);
        $response->assertStatus(422);
        $this->deleteUser($user);
    }

    /**
     * @group profile
     */
     public function testAuthenticatedProfileUpdateInvalidGender(){
        $email = str_random(20) . '@' . str_random(5) . '.' . 'com';
        $user = $this->createUser($email);
        $header = $this->login($user);
        $body = [
            'first_name' => 'Vero',
            'last_name' => 'Onggoro',
            'gender' => 'D',
            'phone' => '0416842836',
            'address' => 'Why so important',
            'suburb' => 'Not really',
            'state' => 'VIC',
            'post_code' => '3000'
        ];
        $response = $this->json('PUT', '/api/profile/edit', $body, $header);
        $response->assertStatus(422);
        $this->deleteUser($user);
    }

    /**
     * @group profile
     */
     public function testAuthenticatedProfileUpdateInvalidPhone(){
        $email = str_random(20) . '@' . str_random(5) . '.' . 'com';
        $user = $this->createUser($email);
        $header = $this->login($user);
        $body = [
            'first_name' => 'Vero',
            'last_name' => 'Onggoro',
            'gender' => 'F',
            'phone' => '041',
            'address' => 'Why so important',
            'suburb' => 'Not really',
            'state' => 'VIC',
            'post_code' => '3000'
        ];
        $response = $this->json('PUT', '/api/profile/edit', $body, $header);
        $response->assertStatus(422);
        $this->deleteUser($user);
    }

    /**
     * @group profile
     */
     public function testAuthenticatedProfileUpdateMissingAddress(){
        $email = str_random(20) . '@' . str_random(5) . '.' . 'com';
        $user = $this->createUser($email);
        $header = $this->login($user);
        $body = [
            'first_name' => 'Vero',
            'last_name' => 'Onggoro',
            'gender' => 'F',
            'phone' => '0416842836',
            'address' => '',
            'suburb' => 'Not really',
            'state' => 'VIC',
            'post_code' => '3000'
        ];
        $response = $this->json('PUT', '/api/profile/edit', $body, $header);
        $response->assertStatus(422);
        $this->deleteUser($user);
    }

    /**
     * @group profile
     */
     public function testAuthenticatedProfileUpdateMissingSuburb(){
        $email = str_random(20) . '@' . str_random(5) . '.' . 'com';
        $user = $this->createUser($email);
        $header = $this->login($user);
        $body = [
            'first_name' => 'Vero',
            'last_name' => 'Onggoro',
            'gender' => 'F',
            'phone' => '0416842836',
            'address' => 'Why so important',
            'suburb' => '',
            'state' => 'VIC',
            'post_code' => '3000'
        ];
        $response = $this->json('PUT', '/api/profile/edit', $body, $header);
        $response->assertStatus(422);
        $this->deleteUser($user);
    }

    /**
     * @group profile
     */
     public function testAuthenticatedProfileUpdateMissingState(){
        $email = str_random(20) . '@' . str_random(5) . '.' . 'com';
        $user = $this->createUser($email);
        $header = $this->login($user);
        $body = [
            'first_name' => 'Vero',
            'last_name' => 'Onggoro',
            'gender' => 'F',
            'phone' => '0416842836',
            'address' => 'Why so important',
            'suburb' => 'Not really',
            'state' => '',
            'post_code' => '3000'
        ];
        $response = $this->json('PUT', '/api/profile/edit', $body, $header);
        $response->assertStatus(422);
        $this->deleteUser($user);
    }

    /**
     * @group driver_license
     */
     public function testNotAuthenticatedDriverLicenseUpdate(){
        $email = str_random(20) . '@' . str_random(5) . '.' . 'com';
        $user = $this->createUser($email);
        $header = $this->login($user);
        $response = $this->json('PUT', '/api/profile/driverlicense/edit', [
            'number' => '123012312',
            'exp_date' => '2017-09-13',
            'country_issuer' => 'Australia'
        ], []);
        $response->assertStatus(200);
        $response->assertJson([
            "status" => 'NOT OK',
            "message" => "Invalid token"
        ]);
        $this->deleteUser($user);
    }

    /**
     * @group driver_license
     */
     public function testAuthenticatedDriverLicenseUpdate(){
        $email = str_random(20) . '@' . str_random(5) . '.' . 'com';
        $user = $this->createUser($email);
        $header = $this->login($user);
        $body = [
            'number' => '123012312',
            'exp_date' => '2017-09-13',
            'country_issuer' => 'Australia'
        ];
        $response = $this->json('PUT', '/api/profile/driverlicense/edit', $body, $header);
        $response->assertStatus(200);
        $data = $response->getData();
        $body = (object)$body;
        $this->assertTrue($body->number == $data->driver_license_number);
        $this->assertTrue($body->exp_date == $data->driver_license_expiry_date);
        $this->assertTrue($body->country_issuer == $data->driver_license_country_issuer);
        $this->deleteUser($user);
    }

    /**
     * @group driver_license
     */
     public function testAuthenticatedDriverLicenseUpdateMissingExpDate(){
        $email = str_random(20) . '@' . str_random(5) . '.' . 'com';
        $user = $this->createUser($email);
        $header = $this->login($user);
        $body = [
            'number' => '123012312',
            'exp_date' => '',
            'country_issuer' => 'Australia'
        ];
        $response = $this->json('PUT', '/api/profile/driverlicense/edit', $body, $header);
        $response->assertStatus(422);
        $this->deleteUser($user);
    }

    /**
     * @group driver_license
     */
     public function testAuthenticatedDriverLicenseUpdateMissingNumber(){
        $email = str_random(20) . '@' . str_random(5) . '.' . 'com';
        $user = $this->createUser($email);
        $header = $this->login($user);
        $body = [
            'number' => '',
            'exp_date' => '2017-09-13',
            'country_issuer' => 'Australia'
        ];
        $response = $this->json('PUT', '/api/profile/driverlicense/edit', $body, $header);
        $response->assertStatus(422);
        $this->deleteUser($user);
    }
}
