<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->increments('aid');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->text('password');
            $table->jsonb('token')->default(json_encode([
                'takengo' => ''
            ]));
            $table->string('phone');
            $table->jsonb('status')->default(json_encode([
                'active' => false
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
        Schema::dropIfExists('admins');
        Schema::enableForeignKeyConstraints();
    }
}
