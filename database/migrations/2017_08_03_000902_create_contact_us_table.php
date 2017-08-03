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

            $table->text('subject');
            $table->longText('content');

            $table->integer('uid')->unsigned()->nullable();
            $table->foreign('uid')
            ->references('uid')
            ->on('users')
            ->onDelete('set null');

            $table->string('email');

            $table->jsonb('status')->default(json_encode([
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
        Schema::dropIfExists('contact_us');
        Schema::enableForeignKeyConstraints();
    }
}
