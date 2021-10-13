<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->foreign('employee_id')->references('id')->on('employees');
            $table->unsignedBigInteger('employee_route_id')->nullable();
            $table->foreign('employee_route_id')->references('id')->on('employee_routes');
            $table->string('wallet_number')->nullable();
            $table->string('date_time')->nullable();
            $table->date('date')->nullable();
            $table->string('time')->nullable();
            $table->string('am_pm')->nullable();
            $table->string('time_str')->nullable();
            $table->string('time_str_am_pm')->nullable();
            $table->enum('status',['1','2','3'])->default('1')->comment = "1=Active, 2=Inactive, 3=Cancel";
            $table->enum('deletable',['1','2'])->default('2')->comment = "1=No, 2=Yes";
            $table->string('created_by')->nullable();
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
        Schema::dropIfExists('attendances');
    }
}
