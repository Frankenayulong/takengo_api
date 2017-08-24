<?php

use Illuminate\Database\Seeder;
use App\Car;
use App\CarLocation;
use App\CarBrand;
use App\CarPicture;

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
        $car1->price = 34.41;
        $car1->save();

        $car2 = new Car;
        $car2->brand()->associate($carBrand2);
        $car2->transition_mode = 'AUTO'; /*Auto / Manual */
        $car2->car_types = 'Hatchback'; /* Sedan, SUV, hatchback, Coach */
        $car2->name = 'Suzuki Swift';
        $car2->release_year = '2010';
        $car2->model = 'Swift';
        $car2->capacity = 5;
        $car2->doors = 4;
        $car2->large_bags = 1;
        $car2->small_bags = 1;
        $car2->air_conditioned = true;
        $car2->unlimited_mileage = true;
        $car2->limit_mileage = 0;
        $car2->fuel_policy = 'Full to Full';
        $car2->price = 44.55;
        $car2->save();

        $car3 = new Car;
        $car3->brand()->associate($carBrand3);
        $car3->transition_mode = 'Manual'; /*Auto / Manual */
        $car3->car_types = 'Hatchback'; /* Sedan, SUV, hatchback, Coach */
        $car3->name = 'Nissan Micra';
        $car3->release_year = '2010';
        $car3->model = 'Micra';
        $car3->capacity = 4;
        $car3->doors = 2;
        $car3->large_bags = 1;
        $car3->small_bags = 1;
        $car3->air_conditioned = true;
        $car3->unlimited_mileage = true;
        $car3->limit_mileage = 0;
        $car3->fuel_policy = 'Full to Full';
        $car3->price = 68.32;
        $car3->save();

        $car4 = new Car;
        $car4->brand()->associate($carBrand4);
        $car4->transition_mode = 'Manual'; /*Auto / Manual */
        $car4->car_types = 'Hatchback'; /* Sedan, SUV, hatchback, Coach */
        $car4->name = 'Hyundai i20';
        $car4->release_year = '2008';
        $car4->model = 'Micra';
        $car4->capacity = 4;
        $car4->doors = 4;
        $car4->large_bags = 1;
        $car4->small_bags = 1;
        $car4->air_conditioned = true;
        $car4->unlimited_mileage = true;
        $car4->limit_mileage = 0;
        $car4->fuel_policy = 'Full to Full';
        $car4->price = 69.42;
        $car4->save();

        $car5 = new Car;
        $car5->brand()->associate($carBrand5);
        $car5->transition_mode = 'AUTO'; /*Auto / Manual */
        $car5->car_types = 'Hatchback'; /* Sedan, SUV, hatchback, Coach */
        $car5->name = 'Toyota Corolla';
        $car5->release_year = '2008';
        $car5->model = 'Corolla';
        $car5->capacity = 5;
        $car5->doors = 4;
        $car5->large_bags = 2;
        $car5->small_bags = 0;
        $car5->air_conditioned = true;
        $car5->unlimited_mileage = true;
        $car5->limit_mileage = 0;
        $car5->fuel_policy = 'Full to Full';
        $car5->price = 37.54;
        $car5->save();

        $car6 = new Car;
        $car6->brand()->associate($carBrand3);
        $car6->transition_mode = 'Manual'; /*Auto / Manual */
        $car6->car_types = 'Sedan'; /* Sedan, SUV, hatchback, Coach */
        $car6->name = 'Nissan Almera';
        $car6->release_year = '2006';
        $car6->model = 'Almera';
        $car6->capacity = 5;
        $car6->doors = 4;
        $car6->large_bags = 2;
        $car6->small_bags = 0;
        $car6->air_conditioned = true;
        $car6->unlimited_mileage = true;
        $car6->limit_mileage = 0;
        $car6->fuel_policy = 'Full to Full';
        $car6->price = 41.67;
        $car6->save();

        $car7 = new Car;
        $car7->brand()->associate($carBrand5);
        $car7->transition_mode = 'AUTO'; /*Auto / Manual */
        $car7->car_types = 'Sedan'; /* Sedan, SUV, hatchback, Coach */
        $car7->name = 'Toyota Corolla';
        $car7->release_year = '2008';
        $car7->model = 'Corolla';
        $car7->capacity = 5;
        $car7->doors = 4;
        $car7->large_bags = 2;
        $car7->small_bags = 1;
        $car7->air_conditioned = true;
        $car7->unlimited_mileage = true;
        $car7->limit_mileage = 0;
        $car7->fuel_policy = 'Full to Full';
        $car7->price = 51.57;
        $car7->save();

        $car8 = new Car;
        $car8->brand()->associate($carBrand4);
        $car8->transition_mode = 'AUTO'; /*Auto / Manual */
        $car8->car_types = 'SUV'; /* Sedan, SUV, hatchback, Coach */
        $car8->name = 'Hyundai Tucson';
        $car8->release_year = '2005';
        $car8->model = 'Tucson';
        $car8->capacity = 5;
        $car8->doors = 4;
        $car8->large_bags = 3;
        $car8->small_bags = 0;
        $car8->air_conditioned = true;
        $car8->unlimited_mileage = true;
        $car8->limit_mileage = 0;
        $car8->fuel_policy = 'Full to Full';
        $car8->price = 91.36;
        $car8->save();

        $car9 = new Car;
        $car9->brand()->associate($carBrand6);
        $car9->transition_mode = 'AUTO'; /*Auto / Manual */
        $car9->car_types = 'Hatchback'; /* Sedan, SUV, hatchback, Coach */
        $car9->name = 'Mercedes A Class';
        $car9->release_year = '2007';
        $car9->model = 'A Class';
        $car9->capacity = 5;
        $car9->doors = 4;
        $car9->large_bags = 2;
        $car9->small_bags = 1;
        $car9->air_conditioned = true;
        $car9->unlimited_mileage = false;
        $car9->limit_mileage = 600;
        $car9->fuel_policy = 'Full to Full';
        $car9->price = 132.53;
        $car9->save();

        $car10 = new Car;
        $car10->brand()->associate($carBrand5);
        $car10->transition_mode = 'AUTO'; /*Auto / Manual */
        $car10->car_types = 'SUV'; /* Sedan, SUV, hatchback, Coach */
        $car10->name = 'Toyota Kluger';
        $car10->release_year = '2001';
        $car10->model = 'Kluger';
        $car10->capacity = 5;
        $car10->doors = 4;
        $car10->large_bags = 3;
        $car10->small_bags = 0;
        $car10->air_conditioned = true;
        $car10->unlimited_mileage = true;
        $car10->limit_mileage = 0;
        $car10->fuel_policy = 'Full to Full';
        $car10->price = 159.04;
        $car10->save();

        /* CAR LOCATIONS */
        $carLocation1 = new CarLocation;
        $carLocation1->lat = -37.831152;
        $carLocation1->long = 144.963147;
        $carLocation1->car()->associate($car1);
        $carLocation1->save();

        $carLocation2 = new CarLocation;
        $carLocation2->lat = -37.8738631;
        $carLocation2->long = 145.02824138;
        $carLocation2->car()->associate($car2);
        $carLocation2->save();

        $carLocation3 = new CarLocation;
        $carLocation3->lat = -37.8810637;
        $carLocation3->long = 144.98792681;
        $carLocation3->car()->associate($car3);
        $carLocation3->save();

        $carLocation4 = new CarLocation;
        $carLocation4->lat = -37.76365286;
        $carLocation4->long = 145.05587537;
        $carLocation4->car()->associate($car4);
        $carLocation4->save();

        $carLocation5 = new CarLocation;
        $carLocation5->lat = -37.82218171;
        $carLocation5->long = 145.02890244;
        $carLocation5->car()->associate($car5);
        $carLocation5->save();

        $carLocation6 = new CarLocation;
        $carLocation6->lat = -37.81797086;
        $carLocation6->long = 144.91186619;
        $carLocation6->car()->associate($car6);
        $carLocation6->save();

        $carLocation7 = new CarLocation;
        $carLocation7->lat = -37.74981616;
        $carLocation7->long = 145.03692821;
        $carLocation7->car()->associate($car7);
        $carLocation7->save();

        $carLocation8 = new CarLocation;
        $carLocation8->lat = -37.81398799;
        $carLocation8->long = 144.98474569;
        $carLocation8->car()->associate($car8);
        $carLocation8->save();

        $carLocation9 = new CarLocation;
        $carLocation9->lat = -37.83843739;
        $carLocation9->long = 144.95795106;
        $carLocation9->car()->associate($car9);
        $carLocation9->save();

        $carLocation10 = new CarLocation;
        $carLocation10->lat = -37.82803468;
        $carLocation10->long = 144.95764189;
        $carLocation10->car()->associate($car10);
        $carLocation10->save();

        /*For Nadya:
        I know things been rough,
        but it's ok..
        Here's something to cheer you up :)
        */
        $carPicture1 = new CarPicture;
        $carPicture1->car()->associate($car1);
        $carPicture1->pic_name = 'm931k.jpg';
        $carPicture1->format = 'jpg';
        $carPicture1->priority = 10; //Hey nad, kalo mau di tampilin di car collection page, bikin 10, kalo ngga bikin 0 aja ya :)
        $carPicture1->save();

        $carPicture10_1 = new CarPicture;
        $carPicture10_1->car()->associate($car10);
        $carPicture10_1->pic_name = 'toyotakluger1.png';
        $carPicture10_1->format = 'png';
        $carPicture1->priority = 10;
        $carPicture10_1->save();
    }
}
