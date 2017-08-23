<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCarsPicturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
     {
         Schema::create('cars_pictures', function (Blueprint $table) {
             $table->increments('cpid');
             $table->integer('cid')->unsigned();
             $table->foreign('cid')
             ->references('cid')
             ->on('cars')
             ->onDelete('cascade');
             $table->text('original_full_path')->nullable();
             $table->text('pic_name');
             $table->string('format');
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
         Schema::dropIfExists('cars_pictures');
         Schema::enableForeignKeyConstraints();
     }
}
