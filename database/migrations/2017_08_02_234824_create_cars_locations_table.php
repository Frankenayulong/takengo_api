<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCarsLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cars_locations', function (Blueprint $table) {
            $table->increments('clid');
            $table->integer('cid')->unsigned();
            $table->foreign('cid')
            ->references('cid')
            ->on('cars')
            ->onDelete('cascade');
            $table->double('lat')->default(0);
            $table->double('long')->default(0);
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
        Schema::dropIfExists('cars_locations');
        Schema::enableForeignKeyConstraints();
    }
}
