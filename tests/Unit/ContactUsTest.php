<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ContactUsTest extends TestCase
{
    /**
     * @group contact-us
     */
     public function testRegisterContactUsInvalidEmail()
     {
         $incorrect_email = str_random(20) . '@' . str_random(5);
         $response = $this->json('POST', '/api/contact-us', 
         [
             'name' => 'Veronica',
             'email' => $incorrect_email,
             'phone' => '0416842836',
             'content' => 'Hey There'
         ]);
         $response->assertStatus(422);
     }

     /**
     * @group contact-us
     */
     public function testRegisterContactUsSuccess()
     {
         $email = str_random(20) . '@' . str_random(5) . '.' . 'com';
         $response = $this->json('POST', '/api/contact-us', 
         [
             'name' => 'Veronica',
             'email' => $email,
             'phone' => '0416842836',
             'content' => 'Hey There'
         ]);
         $response->assertStatus(200);
     }
     /**
     * @group contact-us
     */
     public function testRegisterContactUsMissingName()
     {
         $email = str_random(20) . '@' . str_random(5) . '.' . 'com';
         $response = $this->json('POST', '/api/contact-us', 
         [
             'name' => '',
             'email' => $email,
             'phone' => '0416842836',
             'content' => 'Hey There'
         ]);
         $response->assertStatus(422);
     }

     /**
     * @group contact-us
     */
     public function testRegisterContactUsMissingEmail()
     {
         $response = $this->json('POST', '/api/contact-us', 
         [
             'name' => 'Veronica',
             'email' => '',
             'phone' => '0416842836',
             'content' => 'Hey There'
         ]);
         $response->assertStatus(422);
     }

     /**
     * @group contact-us
     */
     public function testRegisterContactUsMissingPhone()
     {
         $email = str_random(20) . '@' . str_random(5) . '.' . 'com';
         $response = $this->json('POST', '/api/contact-us', 
         [
             'name' => 'Veronica',
             'email' => $email,
             'phone' => '',
             'content' => 'Hey There'
         ]);
         $response->assertStatus(422);
     }

     /**
     * @group contact-us
     */
     public function testRegisterContactUsPhoneExceedLimit()
     {
         $email = str_random(20) . '@' . str_random(5) . '.' . 'com';
         $response = $this->json('POST', '/api/contact-us', 
         [
             'name' => 'Veronica',
             'email' => $email,
             'phone' => '0416842836212',
             'content' => 'Hey There'
         ]);
         $response->assertStatus(422);
     }

     /**
     * @group contact-us
     */
     public function testRegisterContactUsPhoneTooShort()
     {
         $email = str_random(20) . '@' . str_random(5) . '.' . 'com';
         $response = $this->json('POST', '/api/contact-us', 
         [
             'name' => 'Veronica',
             'email' => $email,
             'phone' => '041',
             'content' => 'Hey There'
         ]);
         $response->assertStatus(422);
     }

     /**
     * @group contact-us
     */
     public function testRegisterContactUsMissingContent()
     {
         $email = str_random(20) . '@' . str_random(5) . '.' . 'com';
         $response = $this->json('POST', '/api/contact-us', 
         [
             'name' => 'Veronica',
             'email' => $email,
             'phone' => '0416842836',
             'content' => ''
         ]);
         $response->assertStatus(422);
     }
}
