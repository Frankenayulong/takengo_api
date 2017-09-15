<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Car;

class CarTest extends TestCase
{
    private function createCar(){
        $car = new Car;
        $car->name = "Mazda RX5";
        $car->model = "RX5";
        $car->release_year = "2016";
        $car->transition_mode = 'AUTO';
        $car->car_types = 'SPORT';
        $car->save();
        return $car;
    }

    private function deleteCar($car){
        $car->delete();
    }
    /**
     * @group cars
     */
    public function testGetAllCar()
    {
        $response = $this->get('/api/cars');
        $response->assertStatus(200);
        $response->assertJson([
            'current_page' => true,
            'data' => true,
            'from' => true,
            'last_page' => true,
            'path' => true,
            'per_page' => true,
            'to' => true,
            'total' => true
        ]);
    }

    /**
     * @group cars
     */
     public function testGetDetail()
     {
         $car = $this->createCar();

         $response = $this->get('/api/cars/'.$car->cid);
         $response->assertStatus(200);
         $response->assertJson([
             'status' => true,
             'car' => true
         ]);
         $data = $response->getData();
         $this->assertTrue($data->car->name == $car->name);

         $this->deleteCar($car);
     }
}
