<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Customer;

class RegisterTest extends TestCase
{
    /**
     * @group register
     */
    public function testIncorrectEmailShouldReturnError()
    {
        $incorrect_email = str_random(20) . '@' . str_random(5);
        $response = $this->json('POST', '/api/register', 
        ['email' => $incorrect_email,
        'password' => 'veronicaong',
        'first_name' => 'Veronica',
        'last_name' => 'Ong',
        'password_confirmation' => 'veronicaong'
        ]);
        $response->assertStatus(422);
    }

    /**
     * @group register
     */
     public function testMissingNameShouldReturnError()
     {
         $email = str_random(20) . '@' . str_random(5) . '.' . 'com';
         Customer::where('email', $email)->delete();
         $response = $this->json('POST', '/api/register', 
         ['email' => $email,
         'password' => 'veronicaong',
         'last_name' => 'Ong',
         'password_confirmation' => 'veronicaong'
         ]);
         $response->assertStatus(422);
         $response = $this->json('POST', '/api/register', 
         ['email' => $email,
         'password' => 'testing',
         'first_name' => 'Veronica',
         'password_confirmation' => 'veronicaong'
         ]);
         $response->assertStatus(422);
     }

     /**
     * @group register
     */
     public function testPasswordLengthMin()
     {
         $email = str_random(20) . '@' . str_random(5) . '.' . 'com';
         Customer::where('email', $email)->delete();
         $response = $this->json('POST', '/api/register', 
         ['email' => $email,
         'password' => 'testing',
         'first_name' => 'Veronica',
         'last_name' => 'Ong',
         'password_confirmation' => 'testing'
         ]);
         $response->assertStatus(422);
     }

     /**
     * @group register
     */
     public function testPasswordConfirmation()
     {
         $email = str_random(20) . '@' . str_random(5) . '.' . 'com';
         Customer::where('email', $email)->delete();
         $response = $this->json('POST', '/api/register', 
         ['email' => $email,
         'password' => 'veronicaonggoro',
         'first_name' => 'Veronica',
         'last_name' => 'Ong',
         'password_confirmation' => 'veronicaong'
         ]);
         $response->assertStatus(422);

         $response = $this->json('POST', '/api/register', 
         ['email' => $email,
         'password' => 'veronicaonggoro',
         'first_name' => 'Veronica',
         'last_name' => 'Ong'
         ]);
         $response->assertStatus(422);
     }

     /**
     * @group register
     */
     public function testSuccessRegister()
     {
         $email = str_random(20) . '@' . str_random(5) . '.' . 'com';
         Customer::where('email', $email)->delete();
         $response = $this->json('POST', '/api/register', 
         ['email' => $email,
         'password' => 'veronicaong',
         'password_confirmation' => 'veronicaong',
         'first_name' => 'Veronica',
         'last_name' => 'Ong'
         ]);
         $response->assertStatus(200);
         $response->assertJson([
            'status' => 'OK'
        ]);
        $data = $response->getData();
        $this->assertTrue($email == $data->user->email);
        $this->assertTrue('Veronica' == $data->user->first_name);
        $this->assertTrue('Ong' == $data->user->last_name);
        $customer = Customer::where('email', $email)->first();
        $this->assertTrue($customer != null);
        $customer->delete();
     }
}
