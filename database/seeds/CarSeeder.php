<?php

use Illuminate\Database\Seeder;
use App\Car;
use App\CarLocation;
use App\CarBrand;

class CarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $table_name = (new CarLocation)->getTable();
        $table_name_2 = (new Car)->getTable();
        $table_name_3 = (new CarBrand)->getTable();

        DB::table($table_name)->delete();
        $column = $table_name.'_clid_seq';
        DB::statement("ALTER SEQUENCE $column RESTART WITH 1");

        DB::table($table_name_2)->delete();
        $column = $table_name_2.'_cid_seq';
        DB::statement("ALTER SEQUENCE $column RESTART WITH 1");

        DB::table($table_name_3)->delete();
        $column = $table_name_3.'_cbid_seq';
        DB::statement("ALTER SEQUENCE $column RESTART WITH 1");

        $carBrand1 = new CarBrand;
        $carBrand1->name = 'Audi';
        $carBrand1->save();

        $car1 = new Car;
        $car1->brand()->associate($carBrand1);
        $car1->transition_mode = 'AUTO';
        $car1->car_types = 'SEDAN';
        $car1->name = 'Audo R8';
        $car1->release_year = '2016';
        $car1->model = 'R8';
        $car1->capacity = 4;
        $car1->doors = 4;
        $car1->large_bags = 4;
        $car1->small_bags = 12;
        $car1->air_conditioned = true;
        $car1->unlimited_mileage = false;
        $car1->limit_mileage = 200;
        $car1->fuel_policy = 'Full to Full';
        $car1->save();

        $carLocation1 = new CarLocation;
        $carLocation1->lat = -37.831152;
        $carLocation1->long = 144.963147;
        $carLocation1->car()->associate($car1);
        $carLocation1->save();
    }
}
