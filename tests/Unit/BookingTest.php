<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Customer;
use App\Car;
use App\CarBooking;
use Carbon\Carbon;

class BookingTest extends TestCase
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

    private function createCar(){
        $car = new Car;
        $car->name = "Mazda RX5";
        $car->model = "RX5";
        $car->release_year = "2016";
        $car->transition_mode = 'AUTO';
        $car->car_types = 'SPORT';
        $car->price = 40;
        $car->save();
        return $car;
    }

    private function deleteCar($car){
        $car->delete();
    }

    private function createBooking($user, $car){
        $booking = new CarBooking;
        $booking->car()->associate($car);
        $booking->car_price = $car->price;
        $booking->customer()->associate($user);
        $booking->start_date = Carbon::now();
        $booking->end_date = Carbon::now();
        $booking->save();
        return $booking;
    }

    private function deleteBooking($booking){
        $booking->delete();
    }

    private function deleteBookingByID($id){
        CarBooking::where('ohid', $id)->delete();
    }
    /**
     * @group booking
     */
    public function testAuthenticatedBookingList()
    {
        $email = str_random(20) . '@' . str_random(5) . '.' . 'com';
        $user = $this->createUser($email);
        $header = $this->login($user);
        $car = $this->createCar();
        $booking = $this->createBooking($user, $car);
        $response = $this->json('POST', '/api/book/history', [], $header);
        $response->assertStatus(200);
        $response->assertJson([
            'status' => true,
            'message' => true,
            'bookings' => true
        ]);
        $data = $response->getData();
        $this->assertTrue(count($data->bookings) == 1);
        $this->deleteBooking($booking);
        $this->deleteUser($user);
        $this->deleteCar($car);
        
    }

    /**
     * @group booking
     */
     public function testNotAuthenticatedBookingList()
     {
         $email = str_random(20) . '@' . str_random(5) . '.' . 'com';
         $user = $this->createUser($email);
         $header = $this->login($user);
         $car = $this->createCar();
         $booking = $this->createBooking($user, $car);
         $response = $this->json('POST', '/api/book/history', [], []);
         $response->assertStatus(200);
         $response->assertJson([
             'status' => true,
             'message' => true
         ]);
         $data = $response->getData();
         $this->assertTrue($data->status == 'NOT OK');
         $this->deleteBooking($booking);
         $this->deleteUser($user);
         $this->deleteCar($car);
     }

     /**
     * @group booking
     */
     public function testNotAuthenticatedBook()
     {
         $email = str_random(20) . '@' . str_random(5) . '.' . 'com';
         $user = $this->createUser($email);
         $header = $this->login($user);
         $car = $this->createCar();
         $response = $this->json('POST', '/api/book', [
            'book_end_date' => '2017-09-13',
            'book_start_date' => '2017-09-13',
            'cid' => $car->cid,
            'uid' => $user->uid
         ], []);
         $response->assertStatus(200);
         $response->assertJson([
             'status' => true,
             'message' => true
         ]);
         $data = $response->getData();
         $this->assertTrue($data->status == 'NOT OK');
         $this->deleteUser($user);
         $this->deleteCar($car);
     }

     /**
     * @group booking
     */
     public function testAuthenticatedBookSuccess()
     {
         $email = str_random(20) . '@' . str_random(5) . '.' . 'com';
         $user = $this->createUser($email);
         $header = $this->login($user);
         $car = $this->createCar();
         $response = $this->json('POST', '/api/book', [
            'book_end_date' => '2017-09-13',
            'book_start_date' => '2017-09-13',
            'cid' => $car->cid,
            'uid' => $user->uid
         ], $header);
         $response->assertStatus(200);
         $response->assertJson([
             'status' => true,
             'message' => true,
             'booking' => true
         ]);
         $data = $response->getData();
         $this->assertTrue($data->status == 'OK');
         $this->deleteBookingByID($data->booking);
         $this->deleteUser($user);
         $this->deleteCar($car);
     }

     /**
     * @group booking
     */
     public function testAuthenticatedBookMissingStartDate()
     {
         $email = str_random(20) . '@' . str_random(5) . '.' . 'com';
         $user = $this->createUser($email);
         $header = $this->login($user);
         $car = $this->createCar();
         $response = $this->json('POST', '/api/book', [
            'book_end_date' => '2017-09-13',
            // 'book_start_date' => '2017-09-13',
            'cid' => $car->cid,
            'uid' => $user->uid
         ], $header);
         $response->assertStatus(422);
         $this->deleteUser($user);
         $this->deleteCar($car);
     }

     /**
     * @group booking
     */
     public function testAuthenticatedBookMissingEndDate()
     {
         $email = str_random(20) . '@' . str_random(5) . '.' . 'com';
         $user = $this->createUser($email);
         $header = $this->login($user);
         $car = $this->createCar();
         $response = $this->json('POST', '/api/book', [
            // 'book_end_date' => '2017-09-13',
            'book_start_date' => '2017-09-13',
            'cid' => $car->cid,
            'uid' => $user->uid
         ], $header);
         $response->assertStatus(422);
         $this->deleteUser($user);
         $this->deleteCar($car);
     }

     /**
     * @group booking
     */
     public function testAuthenticatedBookMissingCarID()
     {
         $email = str_random(20) . '@' . str_random(5) . '.' . 'com';
         $user = $this->createUser($email);
         $header = $this->login($user);
         $car = $this->createCar();
         $response = $this->json('POST', '/api/book', [
            'book_end_date' => '2017-09-13',
            'book_start_date' => '2017-09-13',
            // 'cid' => $car->cid,
            'uid' => $user->uid
         ], $header);
         $response->assertStatus(422);
         $this->deleteUser($user);
         $this->deleteCar($car);
     }

     /**
     * @group booking
     */
     public function testAuthenticatedBookInvalidCarID()
     {
         $email = str_random(20) . '@' . str_random(5) . '.' . 'com';
         $user = $this->createUser($email);
         $header = $this->login($user);
         $response = $this->json('POST', '/api/book', [
            'book_end_date' => '2017-09-13',
            'book_start_date' => '2017-09-13',
            'cid' => -1,
            'uid' => $user->uid
         ], $header);
         $response->assertStatus(422);
         $this->deleteUser($user);
     }

     /**
     * @group booking
     */
     public function testAuthenticatedBookInvalidUserID()
     {
         $email = str_random(20) . '@' . str_random(5) . '.' . 'com';
         $user = $this->createUser($email);
         $header = $this->login($user);
         $car = $this->createCar();
         $response = $this->json('POST', '/api/book', [
            'book_end_date' => '2017-09-13',
            'book_start_date' => '2017-09-13',
            'cid' => $car->cid,
            'uid' => -1
         ], $header);
         $response->assertStatus(422);
         $this->deleteUser($user);
         $this->deleteCar($car);
     }

     /**
     * @group booking
     */
     public function testAuthenticatedBookMissingUserID()
     {
         $email = str_random(20) . '@' . str_random(5) . '.' . 'com';
         $user = $this->createUser($email);
         $header = $this->login($user);
         $car = $this->createCar();
         $response = $this->json('POST', '/api/book', [
            'book_end_date' => '2017-09-13',
            'book_start_date' => '2017-09-13',
            'cid' => $car->id,
            // 'uid' => $user->uid
         ], $header);
         $response->assertStatus(422);
         $this->deleteUser($user);
         $this->deleteCar($car);
     }

     /**
     * @group booking
     */
     public function testAuthenticatedStopBooking()
     {
         $email = str_random(20) . '@' . str_random(5) . '.' . 'com';
         $user = $this->createUser($email);
         $header = $this->login($user);
         $car = $this->createCar();
         $booking = $this->createBooking($user, $car);
         sleep(3);
         $response = $this->json('POST', '/api/booking/'.$booking->ohid.'/cancel', [], $header);
         $response->assertStatus(200);
         $response->assertJson([
             'status' => true
         ]);
         $transformed = CarBooking::find($booking->ohid);
         $this->assertFalse($transformed->end_date == $booking->end_date);
         $this->assertFalse($transformed->active);
         $this->deleteBooking($booking);
         $this->deleteUser($user);
         $this->deleteCar($car);
     }

     /**
     * @group booking
     */
     public function testNotAuthenticatedStopBooking()
     {
         $email = str_random(20) . '@' . str_random(5) . '.' . 'com';
         $user = $this->createUser($email);
         $car = $this->createCar();
         $booking = $this->createBooking($user, $car);
         $response = $this->json('POST', '/api/booking/'.$booking->ohid.'/cancel', [], []);
         $response->assertStatus(200);
         $response->assertJson([
             'status' => true,
             'message' => true
         ]);
         $data = $response->getData();
         $this->assertTrue($data->status == 'NOT OK');
         $transformed = CarBooking::find($booking->ohid);
         $this->assertTrue($transformed->active);
         $this->deleteBooking($booking);
         $this->deleteUser($user);
         $this->deleteCar($car);
     }
}
