<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RouteTest extends TestCase
{
    /**
    * @group route
    */
    public function testRootRoute()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $this->assertTrue($response->getStatusCode() != 404);
        $this->assertTrue($response->getStatusCode() != 500);
    }

    /**
    * @group route
    */
    public function testRegisterRoute(){
        $response = $this->post('/api/register');
        $this->assertTrue($response->getStatusCode() != 404);
        $this->assertTrue($response->getStatusCode() != 500);
    }

    /**
    * @group route
    */
    public function testRegisterVendorRoute(){
        $response = $this->post('/api/register/vendor');
        $this->assertTrue($response->getStatusCode() != 404);
        $this->assertTrue($response->getStatusCode() != 500);
    }

    /**
    * @group route
    */
    public function testTokenRoute(){
        $response = $this->post('/api/token');
        $this->assertTrue($response->getStatusCode() != 404);
        $this->assertTrue($response->getStatusCode() != 500);
    }

    /**
    * @group route
    */
    public function testResetAuthRoute(){
        $response = $this->post('/api/reset_auth');
        $this->assertTrue($response->getStatusCode() != 404);
        $this->assertTrue($response->getStatusCode() != 500);
    }

    /**
    * @group route
    */
    public function testProfileRoute(){
        $response = $this->post('/api/profile');
        $this->assertTrue($response->getStatusCode() != 404);
        $this->assertTrue($response->getStatusCode() != 500);
    }

    /**
    * @group route
    */
    public function testProfileEditRoute(){
        $response = $this->put('/api/profile/edit');
        $this->assertTrue($response->getStatusCode() != 404);
        $this->assertTrue($response->getStatusCode() != 500);
    }

    /**
    * @group route
    */
    public function testProfileDriverLicenseEditRoute(){
        $response = $this->put('/api/profile/driverlicense/edit');
        $this->assertTrue($response->getStatusCode() != 404);
        $this->assertTrue($response->getStatusCode() != 500);
    }

    /**
    * @group route
    */
    public function testDocumentUploadRoute(){
        $response = $this->post('/api/user/document/upload');
        $this->assertTrue($response->getStatusCode() != 404);
        $this->assertTrue($response->getStatusCode() != 500);
    }

    /**
    * @group route
    */
    public function testLoginUploadRoute(){
        $response = $this->post('/api/login');
        $this->assertTrue($response->getStatusCode() != 404);
        $this->assertTrue($response->getStatusCode() != 500);
    }

    /**
    * @group route
    */
    public function testCarsRoute(){
        $response = $this->get('/api/cars');
        $response->assertStatus(200);
        $this->assertTrue($response->getStatusCode() != 404);
        $this->assertTrue($response->getStatusCode() != 500);
    }

    /**
    * @group route
    */
    public function testCarDetailRoute(){
        $response = $this->get('/api/cars/1');
        $response->assertStatus(200);
        $this->assertTrue($response->getStatusCode() != 404);
        $this->assertTrue($response->getStatusCode() != 500);
    }

    /**
    * @group route
    */
    public function testCarBookRoute(){
        $response = $this->post('/api/cars/1/book');
        $this->assertTrue($response->getStatusCode() != 404);
        $this->assertTrue($response->getStatusCode() != 500);
    }

    /**
    * @group route
    */
    public function testBookRoute(){
        $response = $this->post('/api/book');
        $this->assertTrue($response->getStatusCode() != 404);
        $this->assertTrue($response->getStatusCode() != 500);
    }

    /**
    * @group route
    */
    public function testBookHistoryRoute(){
        $response = $this->post('/api/book/history');
        $this->assertTrue($response->getStatusCode() != 404);
        $this->assertTrue($response->getStatusCode() != 500);
    }

    /**
    * @group route
    */
    public function testBookPayRoute(){
        $response = $this->post('/api/booking/1/pay');
        $this->assertTrue($response->getStatusCode() != 404);
        $this->assertTrue($response->getStatusCode() != 500);
    }

    /**
    * @group route
    */
    public function testBookCancelRoute(){
        $response = $this->post('/api/booking/1/cancel');
        $this->assertTrue($response->getStatusCode() != 404);
        $this->assertTrue($response->getStatusCode() != 500);
    }

    /**
    * @group route
    */
    public function testContactUsRoute(){
        $response = $this->post('/api/contact-us');
        $this->assertTrue($response->getStatusCode() != 404);
        $this->assertTrue($response->getStatusCode() != 500);
    }

    /**
    * @group route
    */
    public function testRegisterNewsletterRoute(){
        $response = $this->post('/api/register-newsletter');
        $this->assertTrue($response->getStatusCode() != 404);
        $this->assertTrue($response->getStatusCode() != 500);
    }

    /**
    * @group route
    */
    public function testCarImageFirstRoute(){
        $response = $this->post('/img/cars/1');
        $this->assertTrue($response->getStatusCode() != 500);
    }

    /**
    * @group route
    */
    public function testCarImageNameRoute(){
        $response = $this->post('/img/cars/1/asd.jpg');
        $this->assertTrue($response->getStatusCode() != 500);
    }

    /**
    * @group route
    */
    public function testAdminCarsRoute(){
        $response = $this->post('/api/admin/cars');
        $this->assertTrue($response->getStatusCode() != 404);
        $this->assertTrue($response->getStatusCode() != 500);
    }

    /**
    * @group route
    */
    public function testAdminCarUploadPictureRoute(){
        $response = $this->post('/api/admin/cars/1/picture/upload');
        $this->assertTrue($response->getStatusCode() != 404);
        $this->assertTrue($response->getStatusCode() != 500);
    }

    /**
    * @group route
    */
    public function testAdminBrandsRoute(){
        $response = $this->post('/api/admin/brands');
        $this->assertTrue($response->getStatusCode() != 404);
        $this->assertTrue($response->getStatusCode() != 500);
    }

    /**
    * @group route
    */
    public function testAdminCarCreateRoute(){
        $response = $this->post('/api/admin/cars/create');
        $this->assertTrue($response->getStatusCode() != 404);
        $this->assertTrue($response->getStatusCode() != 500);
    }

    /**
    * @group route
    */
    public function testAdminCarShowRoute(){
        $response = $this->post('/api/admin/cars/show/1');
        $this->assertTrue($response->getStatusCode() != 404);
        $this->assertTrue($response->getStatusCode() != 500);
    }

    /**
    * @group route
    */
    public function testAdminOrdersRoute(){
        $response = $this->post('/api/admin/orders');
        $this->assertTrue($response->getStatusCode() != 404);
        $this->assertTrue($response->getStatusCode() != 500);
    }

    /**
    * @group route
    */
    public function testAdminMessagesRoute(){
        $response = $this->post('/api/admin/messages');
        $this->assertTrue($response->getStatusCode() != 404);
        $this->assertTrue($response->getStatusCode() != 500);
    }

    /**
    * @group route
    */
    public function testAdminNewsletterRoute(){
        $response = $this->post('/api/admin/newsletter-emails');
        $this->assertTrue($response->getStatusCode() != 404);
        $this->assertTrue($response->getStatusCode() != 500);
    }

    /**
    * @group route
    */
    public function testAdminUsersRoute(){
        $response = $this->post('/api/admin/users');
        $this->assertTrue($response->getStatusCode() != 404);
        $this->assertTrue($response->getStatusCode() != 500);
    }

    /**
    * @group route
    */
    public function testAdminAdminsRoute(){
        $response = $this->post('/api/admin/admins');
        $this->assertTrue($response->getStatusCode() != 404);
        $this->assertTrue($response->getStatusCode() != 500);
    }
}
