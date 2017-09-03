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

        $car11 = new Car;
        $car11->brand()->associate($carBrand4);
        $car11->transition_mode = 'AUTO'; /*Auto / Manual */
        $car11->car_types = 'Coach'; /* Sedan, SUV, hatchback, Coach */
        $car11->name = 'Hyundai Imax';
        $car11->release_year = '2007';
        $car11->model = 'Imax';
        $car11->capacity = 8;
        $car11->doors = 4;
        $car11->large_bags = 4;
        $car11->small_bags = 0;
        $car11->air_conditioned = true;
        $car11->unlimited_mileage = true;
        $car11->limit_mileage = 0;
        $car11->fuel_policy = 'Full to Full';
        $car11->price = 90.99;
        $car11->save();

        $car12 = new Car;
        $car12->brand()->associate($carBrand5);
        $car12->transition_mode = 'AUTO'; /*Auto / Manual */
        $car12->car_types = 'Coach'; /* Sedan, SUV, hatchback, Coach */
        $car12->name = 'Toyota Commuter Bus';
        $car12->release_year = '2004';
        $car12->model = 'Commuter Bus';
        $car12->capacity = 12;
        $car12->doors = 4;
        $car12->large_bags = 4;
        $car12->small_bags = 0;
        $car12->air_conditioned = true;
        $car12->unlimited_mileage = false;
        $car12->limit_mileage = 600;
        $car12->fuel_policy = 'Full to Full';
        $car12->price = 170.60;
        $car12->save();

        $car13 = new Car;
        $car13->brand()->associate($carBrand4);
        $car13->transition_mode = 'AUTO'; /*Auto / Manual */
        $car13->car_types = 'Coach'; /* Sedan, SUV, hatchback, Coach */
        $car13->name = 'Hyundai Imax';
        $car13->release_year = '2007';
        $car13->model = 'Imax';
        $car13->capacity = 8;
        $car13->doors = 4;
        $car13->large_bags = 4;
        $car13->small_bags = 0;
        $car13->air_conditioned = true;
        $car13->unlimited_mileage = true;
        $car13->limit_mileage = 0;
        $car13->fuel_policy = 'Full to Full';
        $car13->price = 289.15;
        $car13->save();

        $car14 = new Car;
        $car14->brand()->associate($carBrand7);
        $car14->transition_mode = 'AUTO'; /*Auto / Manual */
        $car14->car_types = 'SUV'; /* Sedan, SUV, hatchback, Coach */
        $car14->name = 'Mitsubishi ASX';
        $car14->release_year = '2010';
        $car14->model = 'ASX';
        $car14->capacity = 4;
        $car14->doors = 2;
        $car14->large_bags = 3;
        $car14->small_bags = 0;
        $car14->air_conditioned = true;
        $car14->unlimited_mileage = true;
        $car14->limit_mileage = 0;
        $car14->fuel_policy = 'Full to Full';
        $car14->price = 78.75;
        $car14->save();

        $car15 = new Car;
        $car15->brand()->associate($carBrand5);
        $car15->transition_mode = 'AUTO'; /*Auto / Manual */
        $car15->car_types = 'SUV'; /* Sedan, SUV, hatchback, Coach */
        $car15->name = 'Toyota Rav 4';
        $car15->release_year = '2013';
        $car15->model = 'Rav 4';
        $car15->capacity = 5;
        $car15->doors = 4;
        $car15->large_bags = 3;
        $car15->small_bags = 0;
        $car15->air_conditioned = true;
        $car15->unlimited_mileage = true;
        $car15->limit_mileage = 0;
        $car15->fuel_policy = 'Full to Full';
        $car15->price = 84.68;
        $car15->save();

        $car16 = new Car;
        $car16->brand()->associate($carBrand7);
        $car16->transition_mode = 'AUTO'; /*Auto / Manual */
        $car16->car_types = 'SUV'; /* Sedan, SUV, hatchback, Coach */
        $car16->name = 'Mitsubishi Pajero';
        $car16->release_year = '2006';
        $car16->model = 'Pajero';
        $car16->capacity = 5;
        $car16->doors = 4;
        $car16->large_bags = 3;
        $car16->small_bags = 0;
        $car16->air_conditioned = true;
        $car16->unlimited_mileage = false;
        $car16->limit_mileage = 600;
        $car16->fuel_policy = 'Full to Full';
        $car16->price = 172.15;
        $car16->save();

        /* CAR LOCATIONS */
        /*CAR 1 - Fiat Punto*/
        $carLocation1 = new CarLocation;
        $carLocation1->lat = -37.831152;
        $carLocation1->long = 144.963147;
        $carLocation1->car()->associate($car1);
        $carLocation1->save();

        /*CAR 2 - Suzuki Swift*/
        $carLocation2 = new CarLocation;
        $carLocation2->lat = -37.8738631;
        $carLocation2->long = 145.02824138;
        $carLocation2->car()->associate($car2);
        $carLocation2->save();

        /*CAR 3 - Nissan Micra*/
        $carLocation3 = new CarLocation;
        $carLocation3->lat = -37.8810637;
        $carLocation3->long = 144.98792681;
        $carLocation3->car()->associate($car3);
        $carLocation3->save();

        /*CAR 4 - Hyundai i20*/
        $carLocation4 = new CarLocation;
        $carLocation4->lat = -37.76365286;
        $carLocation4->long = 145.05587537;
        $carLocation4->car()->associate($car4);
        $carLocation4->save();

        /*CAR 5 - Toyota Corolla*/
        $carLocation5 = new CarLocation;
        $carLocation5->lat = -37.82218171;
        $carLocation5->long = 145.02890244;
        $carLocation5->car()->associate($car5);
        $carLocation5->save();

        /*CAR 6 - Nissan Almera*/
        $carLocation6 = new CarLocation;
        $carLocation6->lat = -37.81797086;
        $carLocation6->long = 144.91186619;
        $carLocation6->car()->associate($car6);
        $carLocation6->save();

        /*CAR 7 - Toyota Corolla*/
        $carLocation7 = new CarLocation;
        $carLocation7->lat = -37.74981616;
        $carLocation7->long = 145.03692821;
        $carLocation7->car()->associate($car7);
        $carLocation7->save();

        /*CAR 8 - Hyundai Tucson*/
        $carLocation8 = new CarLocation;
        $carLocation8->lat = -37.81398799;
        $carLocation8->long = 144.98474569;
        $carLocation8->car()->associate($car8);
        $carLocation8->save();

        /*CAR 9 - Mercedes A Class*/
        $carLocation9 = new CarLocation;
        $carLocation9->lat = -37.83843739;
        $carLocation9->long = 144.95795106;
        $carLocation9->car()->associate($car9);
        $carLocation9->save();

        /*CAR 10 - Toyota Kluger*/
        $carLocation10 = new CarLocation;
        $carLocation10->lat = -37.82803468;
        $carLocation10->long = 144.95764189;
        $carLocation10->car()->associate($car10);
        $carLocation10->save();

        /*CAR 11 - Hyundai Imax*/
        $carLocation11 = new CarLocation;
        $carLocation11->lat = -37.85548002;
        $carLocation11->long = 145.0074267;
        $carLocation11->car()->associate($car11);
        $carLocation11->save();

        /*CAR 12 - Toyota Commuter Bus*/
        $carLocation12 = new CarLocation;
        $carLocation12->lat = -37.8188251;
        $carLocation12->long = 144.7890679;
        $carLocation12->car()->associate($car12);
        $carLocation12->save();

        /*CAR 13 - Hyundai Imax*/
        $carLocation13 = new CarLocation;
        $carLocation13->lat = -37.76295292;
        $carLocation13->long = 145.04914141;
        $carLocation13->car()->associate($car13);
        $carLocation13->save();

        /*CAR 14 - Mitsubishi ASX*/
        $carLocation14 = new CarLocation;
        $carLocation14->lat = -37.82182152;
        $carLocation14->long = 144.96678747;
        $carLocation14->car()->associate($car14);
        $carLocation14->save();

        /*CAR 15 - Toyota Rav 4*/
        $carLocation15 = new CarLocation;
        $carLocation15->lat = -37.80930099;
        $carLocation15->long = 144.96704434;
        $carLocation15->car()->associate($car15);
        $carLocation15->save();

        /*CAR 16 - Mitsubishi Pajero*/
        $carLocation16 = new CarLocation;
        $carLocation16->lat = -37.81050385;
        $carLocation16->long = 144.9678224;
        $carLocation16->car()->associate($car16);
        $carLocation16->save();

        /*For Nadya:
        I know things been rough,
        but it's ok..
        Here's something to cheer you up :)
        */
        /*CAR 1 - Fiat Punto*/
        $carPicture1 = new CarPicture;
        $carPicture1->car()->associate($car1);
        $carPicture1->pic_name = 'FiatPunto1.png';
        $carPicture1->format = 'png';
        $carPicture1->priority = 10; //Hey nad, kalo mau di tampilin di car collection page, bikin 10, kalo ngga bikin 0 aja ya :)
        $carPicture1->save();

        $carPicture1_2 = new CarPicture;
        $carPicture1_2->car()->associate($car1);
        $carPicture1_2->pic_name = 'FiatPunto2.png';
        $carPicture1_2->format = 'png';
        $carPicture1_2->priority = 0;
        $carPicture1_2->save();

        $carPicture1_3 = new CarPicture;
        $carPicture1_3->car()->associate($car1);
        $carPicture1_3->pic_name = 'FiatPunto3.png';
        $carPicture1_3->format = 'png';
        $carPicture1_3->priority = 0;
        $carPicture1_3->save();

        $carPicture1_4 = new CarPicture;
        $carPicture1_4->car()->associate($car1);
        $carPicture1_4->pic_name = 'FiatPunto4.png';
        $carPicture1_4->format = 'png';
        $carPicture1_4->priority = 0;

        /*CAR 2 - Suzuki Swift*/
        $carPicture2 = new CarPicture;
        $carPicture2->car()->associate($car2);
        $carPicture2->pic_name = 'suzukiswift1.jpg';
        $carPicture2->format = 'jpg';
        $carPicture2->priority = 10;
        $carPicture2->save();

        $carPicture2_2 = new CarPicture;
        $carPicture2_2->car()->associate($car2);
        $carPicture2_2->pic_name = 'suzukiswift2.jpg';
        $carPicture2_2->format = 'jpg';
        $carPicture2_2->priority = 0;
        $carPicture2_2->save();

        $carPicture2_3 = new CarPicture;
        $carPicture2_3->car()->associate($car2);
        $carPicture2_3->pic_name = 'suzukiswift3.jpg';
        $carPicture2_3->format = 'jpg';
        $carPicture2_3->priority = 0;
        $carPicture2_3->save();

        $carPicture2_4 = new CarPicture;
        $carPicture2_4->car()->associate($car2);
        $carPicture2_4->pic_name = 'suzukiswift4.jpg';
        $carPicture2_4->format = 'jpg';
        $carPicture2_4->priority = 0;
        $carPicture2_4->save();

        /*CAR 3 - Nissan Micra*/
        $carPicture3 = new CarPicture;
        $carPicture3->car()->associate($car3);
        $carPicture3->pic_name = 'nissanMicra1.png';
        $carPicture3->format = 'png';
        $carPicture3->priority = 10;
        $carPicture3->save();

        $carPicture3_2 = new CarPicture;
        $carPicture3_2->car()->associate($car3);
        $carPicture3_2->pic_name = 'nissanMicra2.png';
        $carPicture3_2->format = 'png';
        $carPicture3_2->priority = 0;
        $carPicture3_2->save();

        $carPicture3_3 = new CarPicture;
        $carPicture3_3->car()->associate($car3);
        $carPicture3_3->pic_name = 'nissanMicra3.png';
        $carPicture3_3->format = 'png';
        $carPicture3_3->priority = 0;
        $carPicture3_3->save();

        $carPicture3_4 = new CarPicture;
        $carPicture3_4->car()->associate($car3);
        $carPicture3_4->pic_name = 'nissanMicra4.png';
        $carPicture3_4->format = 'png';
        $carPicture3_4->priority = 0;
        $carPicture3_4->save();

        /*CAR 4 - Hyundai i20*/
        $carPicture4 = new CarPicture;
        $carPicture4->car()->associate($car4);
        $carPicture4->pic_name = 'hyundaii201.png';
        $carPicture4->format = 'png';
        $carPicture4->priority = 10;
        $carPicture4->save();

        $carPicture4_2 = new CarPicture;
        $carPicture4_2->car()->associate($car4);
        $carPicture4_2->pic_name = 'hyundaii202.png';
        $carPicture4_2->format = 'png';
        $carPicture4_2->priority = 0;
        $carPicture4_2->save();

        $carPicture4_3 = new CarPicture;
        $carPicture4_3->car()->associate($car4);
        $carPicture4_3->pic_name = 'hyundaii203.png';
        $carPicture4_3->format = 'png';
        $carPicture4_3->priority = 0;
        $carPicture4_3->save();

        $carPicture4_4 = new CarPicture;
        $carPicture4_4->car()->associate($car4);
        $carPicture4_4->pic_name = 'hyundaii204.png';
        $carPicture4_4->format = 'png';
        $carPicture4_4->priority = 0;
        $carPicture4_4->save();

        /*CAR 5 - Toyota Corolla*/
        $carPicture5 = new CarPicture;
        $carPicture5->car()->associate($car5);
        $carPicture5->pic_name = 'corolla1.jpg';
        $carPicture5->format = 'jpg';
        $carPicture5->priority = 10;
        $carPicture5->save();

        $carPicture5_2 = new CarPicture;
        $carPicture5_2->car()->associate($car5);
        $carPicture5_2->pic_name = 'corolla2.png';
        $carPicture5_2->format = 'png';
        $carPicture5_2->priority = 0;
        $carPicture5_2->save();

        $carPicture5_3 = new CarPicture;
        $carPicture5_3->car()->associate($car5);
        $carPicture5_3->pic_name = 'corolla3.png';
        $carPicture5_3->format = 'png';
        $carPicture5_3->priority = 0;
        $carPicture5_3->save();

        $carPicture5_4 = new CarPicture;
        $carPicture5_4->car()->associate($car5);
        $carPicture5_4->pic_name = 'corolla4.jpg';
        $carPicture5_4->format = 'jpg';
        $carPicture5_4->priority = 0;
        $carPicture5_4->save();

        /*CAR 6 - Nissan Almera*/
        $carPicture6 = new CarPicture;
        $carPicture6->car()->associate($car6);
        $carPicture6->pic_name = 'nissanAlmera1.png';
        $carPicture6->format = 'png';
        $carPicture6->priority = 10;
        $carPicture6->save();

        $carPicture6_2 = new CarPicture;
        $carPicture6_2->car()->associate($car6);
        $carPicture6_2->pic_name = 'nissanAlmera2.png';
        $carPicture6_2->format = 'png';
        $carPicture6_2->priority = 0;
        $carPicture6_2->save();

        $carPicture6_3 = new CarPicture;
        $carPicture6_3->car()->associate($car6);
        $carPicture6_3->pic_name = 'nissanAlmera3.png';
        $carPicture6_3->format = 'png';
        $carPicture6_3->priority = 0;
        $carPicture6_3->save();

        $carPicture6_4 = new CarPicture;
        $carPicture6_4->car()->associate($car6);
        $carPicture6_4->pic_name = 'nissanAlmera4.png';
        $carPicture6_4->format = 'png';
        $carPicture6_4->priority = 0;
        $carPicture6_4->save();

        /*CAR 7 - Toyota Corolla*/
        $carPicture7 = new CarPicture;
        $carPicture7->car()->associate($car7);
        $carPicture7->pic_name = 'corolla1.jpg';
        $carPicture7->format = 'jpg';
        $carPicture7->priority = 10;
        $carPicture7->save();

        $carPicture7_2 = new CarPicture;
        $carPicture7_2->car()->associate($car7);
        $carPicture7_2->pic_name = 'corolla2.png';
        $carPicture7_2->format = 'png';
        $carPicture7_2->priority = 0;
        $carPicture7_2->save();

        $carPicture7_3 = new CarPicture;
        $carPicture7_3->car()->associate($car7);
        $carPicture7_3->pic_name = 'corolla3.png';
        $carPicture7_3->format = 'png';
        $carPicture7_3->priority = 0;
        $carPicture7_3->save();

        $carPicture7_4 = new CarPicture;
        $carPicture7_4->car()->associate($car7);
        $carPicture7_4->pic_name = 'corolla4.jpg';
        $carPicture7_4->format = 'jpg';
        $carPicture7_4->priority = 0;
        $carPicture7_4->save();

        /*CAR 8 - Hyundai Tucson*/
        $carPicture8 = new CarPicture;
        $carPicture8->car()->associate($car8);
        $carPicture8->pic_name = 'hyundaiTucson.png';
        $carPicture8->format = 'png';
        $carPicture8->priority = 10;
        $carPicture8->save();

        $carPicture8_2 = new CarPicture;
        $carPicture8_2->car()->associate($car8);
        $carPicture8_2->pic_name = 'hyundaiTucson1.png';
        $carPicture8_2->format = 'png';
        $carPicture8_2->priority = 0;
        $carPicture8_2->save();

        $carPicture8_3 = new CarPicture;
        $carPicture8_3->car()->associate($car8);
        $carPicture8_3->pic_name = 'hyundaiTucson2.png';
        $carPicture8_3->format = 'png';
        $carPicture8_3->priority = 0;
        $carPicture8_3->save();

        $carPicture8_4 = new CarPicture;
        $carPicture8_4->car()->associate($car8);
        $carPicture8_4->pic_name = 'hyundaiTucson3.png';
        $carPicture8_4->format = 'png';
        $carPicture8_4->priority = 0;
        $carPicture8_4->save();

        $carPicture8_5 = new CarPicture;
        $carPicture8_5->car()->associate($car8);
        $carPicture8_5->pic_name = 'hyundaiTucson4.png';
        $carPicture8_5->format = 'png';
        $carPicture8_5->priority = 0;
        $carPicture8_5->save();

        /*CAR 9 - Mercedes A Class*/
        $carPicture9 = new CarPicture;
        $carPicture9->car()->associate($car9);
        $carPicture9->pic_name = 'mercedesAclass1.png';
        $carPicture9->format = 'png';
        $carPicture9->priority = 10;
        $carPicture9->save();

        $carPicture9_2 = new CarPicture;
        $carPicture9_2->car()->associate($car9);
        $carPicture9_2->pic_name = 'mercedesAclass2.png';
        $carPicture9_2->format = 'png';
        $carPicture9_2->priority = 0;
        $carPicture9_2->save();

        $carPicture9_3 = new CarPicture;
        $carPicture9_3->car()->associate($car9);
        $carPicture9_3->pic_name = 'mercedesAclass3.png';
        $carPicture9_3->format = 'png';
        $carPicture9_3->priority = 0;
        $carPicture9_3->save();

        /*CAR 10 - Toyota Kluger*/
        $carPicture10 = new CarPicture;
        $carPicture10->car()->associate($car10);
        $carPicture10->pic_name = 'toyotakluger1.png';
        $carPicture10->format = 'png';
        $carPicture10->priority = 10;
        $carPicture10->save();

        $carPicture10_2 = new CarPicture;
        $carPicture10_2->car()->associate($car10);
        $carPicture10_2->pic_name = 'toyotakluger2.png';
        $carPicture10_2->format = 'png';
        $carPicture10_2->priority = 0;
        $carPicture10_2->save();

        $carPicture10_3 = new CarPicture;
        $carPicture10_3->car()->associate($car10);
        $carPicture10_3->pic_name = 'toyotakluger3.png';
        $carPicture10_3->format = 'png';
        $carPicture10_3->priority = 0;
        $carPicture10_3->save();

        $carPicture10_4 = new CarPicture;
        $carPicture10_4->car()->associate($car10);
        $carPicture10_4->pic_name = 'toyotakluger4.png';
        $carPicture10_4->format = 'png';
        $carPicture10_4->priority = 0;
        $carPicture10_4->save();

        /*CAR 11 - Hyundai Imax*/
        $carPicture11 = new CarPicture;
        $carPicture11->car()->associate($car11);
        $carPicture11->pic_name = 'hyundaiImax1.jpg';
        $carPicture11->format = 'jpg';
        $carPicture11->priority = 10;
        $carPicture11->save();

        $carPicture11_2 = new CarPicture;
        $carPicture11_2->car()->associate($car11);
        $carPicture11_2->pic_name = 'hyundaiImax2.png';
        $carPicture11_2->format = 'png';
        $carPicture11_2->priority = 0;
        $carPicture11_2->save();

        $carPicture11_3 = new CarPicture;
        $carPicture11_3->car()->associate($car11);
        $carPicture11_3->pic_name = 'hyundaiImax3.jpg';
        $carPicture11_3->format = 'jpg';
        $carPicture11_3->priority = 0;
        $carPicture11_3->save();

        /*CAR 12 - Toyota Commuter Bus*/
        $carPicture12 = new CarPicture;
        $carPicture12->car()->associate($car12);
        $carPicture12->pic_name = 'toyotaCommuter.png';
        $carPicture12->format = 'png';
        $carPicture12->priority = 10;
        $carPicture12->save();

        $carPicture12_2 = new CarPicture;
        $carPicture12_2->car()->associate($car12);
        $carPicture12_2->pic_name = 'toyotaCommuter1.png';
        $carPicture12_2->format = 'png';
        $carPicture12_2->priority = 0;
        $carPicture12_2->save();

        $carPicture12_3 = new CarPicture;
        $carPicture12_3->car()->associate($car12);
        $carPicture12_3->pic_name = 'toyotaCommuter2.png';
        $carPicture12_3->format = 'png';
        $carPicture12_3->priority = 0;
        $carPicture12_3->save();

        $carPicture12_4 = new CarPicture;
        $carPicture12_4->car()->associate($car12);
        $carPicture12_4->pic_name = 'toyotaCommuter3.png';
        $carPicture12_4->format = 'png';
        $carPicture12_4->priority = 0;
        $carPicture12_4->save();

        $carPicture12_5 = new CarPicture;
        $carPicture12_5->car()->associate($car12);
        $carPicture12_5->pic_name = 'toyotaCommuter4.png';
        $carPicture12_5->format = 'png';
        $carPicture12_5->priority = 0;
        $carPicture12_5->save();

        $carPicture12_6 = new CarPicture;
        $carPicture12_6->car()->associate($car12);
        $carPicture12_6->pic_name = 'toyotaCommuter5.png';
        $carPicture12_6->format = 'png';
        $carPicture12_6->priority = 0;
        $carPicture12_6->save();

        /*CAR 13 - Hyundai Imax*/
        $carPicture13 = new CarPicture;
        $carPicture13->car()->associate($car13);
        $carPicture13->pic_name = 'hyundaiImax1.jpg';
        $carPicture13->format = 'jpg';
        $carPicture13->priority = 10;
        $carPicture13->save();

        $carPicture13_2 = new CarPicture;
        $carPicture13_2->car()->associate($car13);
        $carPicture13_2->pic_name = 'hyundaiImax2.png';
        $carPicture13_2->format = 'png';
        $carPicture13_2->priority = 0;
        $carPicture13_2->save();

        $carPicture13_3 = new CarPicture;
        $carPicture13_3->car()->associate($car13);
        $carPicture13_3->pic_name = 'hyundaiImax3.jpg';
        $carPicture13_3->format = 'jpg';
        $carPicture13_3->priority = 0;
        $carPicture13_3->save();

        /*CAR 14 - Mitsubishi ASX*/
        $carPicture14 = new CarPicture;
        $carPicture14->car()->associate($car14);
        $carPicture14->pic_name = 'mitsubishiasx.png';
        $carPicture14->format = 'png';
        $carPicture14->priority = 10;
        $carPicture14->save();

        $carPicture14_2 = new CarPicture;
        $carPicture14_2->car()->associate($car14);
        $carPicture14_2->pic_name = 'mitsubishiasx1.png';
        $carPicture14_2->format = 'png';
        $carPicture14_2->priority = 0;
        $carPicture14_2->save();

        $carPicture14_3 = new CarPicture;
        $carPicture14_3->car()->associate($car14);
        $carPicture14_3->pic_name = 'mitsubishiasx2.png';
        $carPicture14_3->format = 'png';
        $carPicture14_3->priority = 0;
        $carPicture14_3->save();

        /*CAR 15 - Toyota Rav 4*/
        $carPicture15 = new CarPicture;
        $carPicture15->car()->associate($car15);
        $carPicture15->pic_name = 'toyotaRav4.png';
        $carPicture15->format = 'png';
        $carPicture15->priority = 10;
        $carPicture15->save();

        $carPicture15_2 = new CarPicture;
        $carPicture15_2->car()->associate($car15);
        $carPicture15_2->pic_name = 'toyotaRav41.png';
        $carPicture15_2->format = 'png';
        $carPicture15_2->priority = 0;
        $carPicture15_2->save();

        $carPicture15_3 = new CarPicture;
        $carPicture15_3->car()->associate($car15);
        $carPicture15_3->pic_name = 'toyotaRav42.png';
        $carPicture15_3->format = 'png';
        $carPicture15_3->priority = 0;
        $carPicture15_3->save();

        $carPicture15_4 = new CarPicture;
        $carPicture15_4->car()->associate($car15);
        $carPicture15_4->pic_name = 'toyotaRav43.png';
        $carPicture15_4->format = 'png';
        $carPicture15_4->priority = 0;
        $carPicture15_4->save();

        /*CAR 16 - Mitsubishi Pajero*/
        $carPicture16 = new CarPicture;
        $carPicture16->car()->associate($car16);
        $carPicture16->pic_name = 'mitsubishiPajero1.png';
        $carPicture16->format = 'png';
        $carPicture16->priority = 10;
        $carPicture16->save();

        $carPicture16_2 = new CarPicture;
        $carPicture16_2->car()->associate($car16);
        $carPicture16_2->pic_name = 'mitsubishiPajero2.png';
        $carPicture16_2->format = 'png';
        $carPicture16_2->priority = 0;
        $carPicture16_2->save();

        $carPicture16_3 = new CarPicture;
        $carPicture16_3->car()->associate($car16);
        $carPicture16_3->pic_name = 'mitsubishiPajero3.png';
        $carPicture16_3->format = 'png';
        $carPicture16_3->priority = 0;
        $carPicture16_3->save();
    }
}
