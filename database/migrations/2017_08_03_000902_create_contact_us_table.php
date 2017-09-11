<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactUsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact_us', function (Blueprint $table) {
            $table->increments('cuid');

            $table->text('name');
            $table->string('email');
            $table->string('phone');
            $table->longText('content');
            $table->boolean('resolved')->default(false);

            // $table->json('status')->default(json_encode([
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
        Schema::dropIfExists('contact_us');
        Schema::enableForeignKeyConstraints();
    }
}
