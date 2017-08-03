<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('uid');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->date('birth_date')->nullable();
            $table->string('gender', 1);
            $table->text('password');
            $table->jsonb('location_origin')->default(json_encode([
                'address' => '',
                'city' => '',
                'country' => '',
                'postcode' => ''
            ]));
            $table->jsonb('token')->default(json_encode([
                'takengo' => '',
                'google' => '',
                'facebook' => ''
            ]));
            $table->jsonb('driver_license')->default(json_encode([
                'picture' => '',
                'number' => '',
                'expiry_date' => '',
                'country_issuer' => ''
            ]));
            $table->string('phone');
            $table->jsonb('status')->default(json_encode([
                'verified' => false,
                'license' => false
            ]));
            $table->jsonb('metadata')->default(json_encode([
                'notes' => json_encode([]),
                'ips' => json_encode([])
            ]));
            $table->ipAddress('last_ip');
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
        Schema::dropIfExists('users');
        Schema::enableForeignKeyConstraints();
    }
}
