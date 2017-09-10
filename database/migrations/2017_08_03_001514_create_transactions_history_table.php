<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions_history', function (Blueprint $table) {
            $table->increments('thid');

            $table->integer('ohid')->unsigned()->nullable();
            $table->foreign('ohid')
            ->references('ohid')
            ->on('orders_history')
            ->onDelete('set null');

            $table->integer('ucid')->unsigned()->nullable();
            $table->foreign('ucid')
            ->references('ucid')
            ->on('users_cards')
            ->onDelete('set null');
            
            $table->double('amount');
            $table->text('card');
            $table->text('card_type');
            // $table->json('status')->default(json_encode([
            //     'card' => '', //DECLINED / APPROVED
            //     'type' => '' //SAVINGS / CREDIT / DEBIT
            // ]));

            // $table->json('metadata')->default(json_encode([
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
        Schema::dropIfExists('transactions_history');
        Schema::enableForeignKeyConstraints();
    }
}
