<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_cards', function (Blueprint $table) {
            $table->increments('ucid');
            $table->integer('uid')->unsigned();
            $table->foreign('uid')
            ->references('uid')
            ->on('users')
            ->onDelete('cascade');

            $table->string('card_type');
            $table->string('card_number')->index();
            $table->integer('exp_month')->unsigned();
            $table->integer('exp_year')->unsigned();
            $table->string('cvv');
            $table->string('card_holder');
            $table->string('issuer');
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
        Schema::dropIfExists('users_cards');
        Schema::enableForeignKeyConstraints();
    }
}
