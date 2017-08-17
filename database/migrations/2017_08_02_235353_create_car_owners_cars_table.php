<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCarOwnersCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('car_owner_cars', function (Blueprint $table) {
            $table->increments('cocid');
            
            $table->integer('coid')->unsigned();
            $table->foreign('coid')
            ->references('coid')
            ->on('car_owners')
            ->onDelete('cascade');

            $table->integer('cid')->unsigned();
            $table->foreign('cid')
            ->references('cid')
            ->on('cars')
            ->onDelete('cascade');

            // $table->json('status')->default(json_encode([
            //     'active' => true,
            //     'notes' => json_encode([])
            // ]));
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
        Schema::dropIfExists('car_owner_cars');
        Schema::enableForeignKeyConstraints();
    }
}
