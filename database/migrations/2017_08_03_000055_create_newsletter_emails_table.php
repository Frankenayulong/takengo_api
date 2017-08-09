<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsletterEmailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('newsletter_emails', function (Blueprint $table) {
            $table->increments('neid');
            $table->string('email')->unique();
            $table->json('status')->default(json_encode([
                'active' => false
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
        Schema::dropIfExists('newsletter_emails');
        Schema::enableForeignKeyConstraints();
    }
}
