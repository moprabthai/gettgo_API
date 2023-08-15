<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_ot_details', function (Blueprint $table) {
            $table->id();
            $table->integer('no');
            $table->dateTime('time_start');
            $table->dateTime('time_end');
            $table->integer('type');
            $table->float('price_of_hours');
            $table->float('total_hours');
            $table->float('total_price');
            $table->boolean('note');
            $table->string('comment');
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
        Schema::dropIfExists('request_ot__details');
    }
};
