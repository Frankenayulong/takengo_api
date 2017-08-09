<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCarOwnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('car_owners', function (Blueprint $table) {
            $table->increments('coid');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();

            $table->integer('uid')->unsigned()->nullable();
            $table->foreign('uid')
            ->references('uid')
            ->on('users')
            ->onDelete('set null');

            $table->json('required_documents')->default(json_encode([
                'tax' => json_encode([
                    'url' => '',
                    'accepted' => false
                ])
            ]));
            
            $table->json('bank_details')->default(json_encode([
                'account_number' => '',
                'bsb' => '',
                'bank' => '',
                'account_holder' => ''
            ]));
            $table->string('phone');
            $table->json('status')->default(json_encode([
                'verified' => false
            ]));
            $table->json('metadata')->default(json_encode([
                'notes' => json_encode([])
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
        Schema::dropIfExists('car_owners');
        Schema::enableForeignKeyConstraints();
    }
}
