<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewslettersHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('newsletters_history', function (Blueprint $table) {
            $table->increments('nhid');

            $table->integer('ncid')->unsigned();
            $table->foreign('ncid')
            ->references('ncid')
            ->on('newsletters_content')
            ->onDelete('cascade');

            $table->integer('neid')->unsigned();
            $table->foreign('neid')
            ->references('neid')
            ->on('newsletter_emails')
            ->onDelete('cascade');

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
        Schema::dropIfExists('newsletters_history');
        Schema::enableForeignKeyConstraints();
    }
}
