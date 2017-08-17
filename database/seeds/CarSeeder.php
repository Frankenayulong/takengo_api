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

        /* CAR BRANDS */
        $carBrand1 = new CarBrand;
        $carBrand1->name = 'Fiat';
        $carBrand1->save();

        $carBrand2 = new CarBrand;
        $carBrand2->name = 'Suzuki';
        $carBrand2->save();

        $carBrand3 = new CarBrand;
        $carBrand3->name = 'Nissan';
        $carBrand3->save();

        $carBrand4 = new CarBrand;
        $carBrand4->name = 'Hyundai';
        $carBrand4->save();

        $carBrand5 = new CarBrand;
        $carBrand5->name = 'Toyota';
        $carBrand5->save();

        $carBrand6 = new CarBrand;
        $carBrand6->name = 'Mercedes';
        $carBrand6->save();

        $carBrand7 = new CarBrand;
        $carBrand7->name = 'Mitsubishi';
        $carBrand7->save();

        $carBrand8 = new CarBrand;
        $carBrand8->name = 'Holden';
        $carBrand8->save();

        $carBrand9 = new CarBrand;
        $carBrand9->name = 'Ford';
        $carBrand9->save();

        $carBrand10 = new CarBrand;
        $carBrand10->name = 'Kia';
        $carBrand10->save();

        $carBrand11 = new CarBrand;
        $carBrand11->name = 'Volkswagen';
        $carBrand11->save();

        $carBrand12 = new CarBrand;
        $carBrand12->name = 'Skoda';
        $carBrand12->save();

        /* CAR TYPES */
        $car1 = new Car;
        $car1->brand()->associate($carBrand1);
        $car1->transition_mode = 'AUTO'; /*Auto / Manual */
        $car1->car_types = 'Hatchback'; /* Sedan, SUV, hatchback, Coach */
        $car1->name = 'Fiat Punto';
        $car1->release_year = '2012';
        $car1->model = 'Punto';
        $car1->capacity = 4;
        $car1->doors = 4;
        $car1->large_bags = 1;
        $car1->small_bags = 1;
        $car1->air_conditioned = true;
        $car1->unlimited_mileage = true;
        $car1->limit_mileage = 0;
        $car1->fuel_policy = 'Full to Full';
        $car1->save();

        /* CAR LOCATIONS */
        $carLocation1 = new CarLocation;
        $carLocation1->lat = -37.831152;
        $carLocation1->long = 144.963147;
        $carLocation1->car()->associate($car1);
        $carLocation1->save();
    }
}
