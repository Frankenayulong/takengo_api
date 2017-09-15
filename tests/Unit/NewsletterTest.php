<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class NewsletterTest extends TestCase
{
    /**
     * @group newsletter
     */
    public function testRegisterNewsletterInvalidEmail()
    {
        $incorrect_email = str_random(20) . '@' . str_random(5);
        $response = $this->json('POST', '/api/register-newsletter', 
        [
            'email' => $incorrect_email
        ]);
        $response->assertStatus(422);
    }

    /**
     * @group newsletter
     */
     public function testRegisterNewsletterMissingEmail()
     {
         $response = $this->json('POST', '/api/register-newsletter', 
         []);
         $response->assertStatus(422);
     }

    /**
     * @group newsletter
     */
     public function testRegisterNewsletterSuccess()
     {
         $email = str_random(20) . '@' . str_random(5) . '.' . 'com';
         $response = $this->json('POST', '/api/register-newsletter', 
         [
             'email' => $email
         ]);
         $response->assertStatus(200);
         $response->assertJson([
            'status' => 'OK',
            'message' => 'Email registered'
         ]);
     }

     /**
     * @group newsletter
     */
     public function testRegisterNewsletterDuplicate()
     {
         $email = str_random(20) . '@' . str_random(5) . '.' . 'com';
         $response = $this->json('POST', '/api/register-newsletter', 
         [
             'email' => $email
         ]);
         $response->assertStatus(200);
         $response->assertJson([
            'status' => 'OK',
            'message' => 'Email registered'
         ]);
         $response = $this->json('POST', '/api/register-newsletter', 
         [
             'email' => $email
         ]);
         $response->assertStatus(422);
     }
}
