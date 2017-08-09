<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewslettersContentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('newsletters_content', function (Blueprint $table) {
            $table->increments('ncid');
            $table->text('subject');
            $table->longText('content');

            $table->integer('aid')->unsigned()->nullable();
            $table->foreign('aid')
            ->references('aid')
            ->on('admins')
            ->onDelete('set null');

            $table->json('status')->default(json_encode([
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
        Schema::dropIfExists('newsletters_content');
        Schema::enableForeignKeyConstraints();
    }
}
