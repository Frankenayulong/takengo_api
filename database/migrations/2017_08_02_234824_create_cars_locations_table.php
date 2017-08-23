<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
class CreateCarsLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cars_locations', function (Blueprint $table) {
            $table->increments('clid');
            $table->integer('cid')->unsigned();
            $table->foreign('cid')
            ->references('cid')
            ->on('cars')
            ->onDelete('cascade');
            $table->double('lat')->default(0);
            $table->double('long')->default(0);
            $table->timestamps();
        });

        Schema::table('cars_locations', function(Blueprint $table){
            $sql = "CREATE INDEX cars_locations_lat_lng_index on cars_locations USING gist(ll_to_earth(lat, long));";
            DB::connection()->getPdo()->exec($sql);
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
        $sql = "DROP INDEX cars_locations_lat_lng_index"; 
        DB::connection()->getPdo()->exec($sql);
        Schema::dropIfExists('cars_locations');
        Schema::enableForeignKeyConstraints();
    }
}
