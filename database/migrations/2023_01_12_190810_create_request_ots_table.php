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
        Schema::create('request_ots', function (Blueprint $table) {
            $table->id();
            $table->string('requestNo');
            $table->string('requestStatus');
            $table->date('requestDate');
            $table->string('employeeID');
            $table->string('employeeName');
            $table->string('approverID');
            $table->string('approverName');
            $table->float('salaray');
            $table->string('shift');
            $table->string('shiftTime');
            $table->string('shiftBreak');
            $table->string('shiftWeekend');
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
        Schema::dropIfExists('request_ots');
    }
};
