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
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->unique();
            $table->date('birth_date')->nullable();
            $table->string('gender', 1)->default('U');
            $table->text('address')->nullable();
            $table->string('suburb')->nullable();
            $table->string('state')->nullable();
            $table->string('post_code')->nullable();
            $table->string('token')->default('');
            $table->string('password');
            // $table->string('fb_uid')->unique()->nullable();

            $table->text('driver_license_picture')->nullable();
            $table->string('driver_license_number')->nullable();
            $table->date('driver_license_expiry_date')->nullable();
            $table->string('driver_license_country_issuer')->nullable();


            $table->string('phone')->nullable();

            $table->boolean('s_verified')->default(false);
            $table->boolean('s_all_verified')->default(false);
            $table->boolean('s_license')->default(false);
            $table->boolean('s_address')->default(false);
            $table->boolean('s_filled')->default(false);
            $table->string('vendor', 10)->default('takengo');
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
