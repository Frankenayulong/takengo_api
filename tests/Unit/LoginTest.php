<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Customer;

class LoginTest extends TestCase
{

    private function createUser($email){
        Customer::where('email', $email)->delete();
        $user = new Customer;
        $user->first_name = 'Veronica';
        $user->last_name = 'Ong';
        $user->email = $email;
        $user->password = bcrypt('testing');
        $user->last_ip = '::1';
        $user->save();
        return $user;
    }

    private function deleteUser($user){
        $user->delete();
    }

    /**
    * @group login
    */
    public function testIncorrectEmail(){
        $incorrect_email = str_random(20) . '@' . str_random('5');
        $email = str_random(20) . '@' . str_random('5') . '.' . str_random('3');
        Customer::where('email', $email)->delete();
        $response = $this->json('POST', '/api/login', 
        ['email' => $incorrect_email,
        'password' => 'testing']);
        $response->assertStatus(422);

        $response = $this->json('POST', '/api/login', 
        ['password' => 'testing']);
        $response->assertStatus(422);

        $response = $this->json('POST', '/api/login', 
        ['email' => $email,
        'password' => 'testing']);
        $response->assertStatus(422);
    }

    /**
    * @group login
    */
    public function testSuccessLogin(){
        $email = str_random(20) . '@' . str_random('5') . '.' . str_random('3');
        $user = $this->createUser($email);
        $response = $this->json('POST', '/api/login', 
        ['email' => $email,
        'password' => 'testing']);
        $response->assertStatus(200);
        $response->assertJson([
            'status' => 'OK'
        ]);
        $data = $response->getData();
        $this->assertTrue($user->uid == $data->uid);
        $this->assertTrue($user->email == $data->email);
        $this->assertTrue(strlen($data->token) > 0);
        $this->deleteuser($user);
    }

    /**
    * @group login
    */
    public function testWrongPassword(){
        $email = str_random(20) . '@' . str_random('5') . '.' . str_random('3');
        $user = $this->createUser($email);
        $response = $this->json('POST', '/api/login', 
        ['email' => $email,
        'password' => 'nottesting']);
        $response->assertStatus(200);
        $response->assertJson([
            'status' => 'NOTOK',
            'message' => 'Invalid Credentials'
        ]);
        $this->deleteuser($user);
    }
}
