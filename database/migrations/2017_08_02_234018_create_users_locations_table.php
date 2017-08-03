<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_locations', function (Blueprint $table) {
            $table->increments('ulid');
            $table->integer('uid')->unsigned();
            $table->foreign('uid')
            ->references('uid')
            ->on('users')
            ->onDelete('cascade');
            $table->jsonb('location')->default(json_encode([
                'lat' => '',
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
        Schema::dropIfExists('users_locations');
        Schema::enableForeignKeyConstraints();
    }
}
