<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->increments('cid');

            $table->integer('cbid')->unsigned();
            $table->foreign('cbid')
            ->references('cbid')
            ->on('car_brands')
            ->onDelete('set null');

            $table->string('transition_mode')
            ->comment('AUTO / MANUAL');
            $table->string('car_types')
            ->comment('SEDAN / SUV / TRUCK / ETC');
            $table->string('name');
            $table->string('release_year', 4);
            $table->string('model');
            $table->integer('capacity')->unsigned();
            $table->jsonb('conditions')->default(json_encode([

            ]));
            $table->jsonb('metadata')->default(json_encode([
                'notes' => json_encode([]),
                'long' => ''
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
        Schema::dropIfExists('cars');
        Schema::enableForeignKeyConstraints();
    }
}
