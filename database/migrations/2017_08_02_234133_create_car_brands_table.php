<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCarBrandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('car_brands', function (Blueprint $table) {
            $table->increments('cbid');
            $table->string('name');
            $table->json('metadata')->default(json_encode([
                'logo' => '',
                'country_origin' => '',
                'description' => ''
            ]));
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints(); 
        Schema::dropIfExists('car_brands');
        Schema::enableForeignKeyConstraints();
    }
}
