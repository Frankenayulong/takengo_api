<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders_history', function (Blueprint $table) {
            $table->increments('ohid');

            $table->integer('cid')->unsigned()->nullable();
            $table->foreign('cid')
            ->references('cid')
            ->on('cars')
            ->onDelete('set null');

            $table->integer('uid')->unsigned();
            $table->foreign('uid')
            ->references('uid')
            ->on('users')
            ->onDelete('cascade');

            $table->date('start_date');
            $table->date('end_date');

            $table->double('user_lat')->default(0);
            $table->double('user_long')->default(0);

            $table->double('car_lat')->default(0);
            $table->double('car_long')->default(0);

            // $table->json('metadata')->default(json_encode([
            //     'notes' => json_encode([]),
            //     'locations' => json_encode([
            //         'lat' => '',
            //         'long' => ''
            //     ])
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
        Schema::dropIfExists('orders_history');
        Schema::enableForeignKeyConstraints();
    }
}
