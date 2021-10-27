<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDealersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dealers', function (Blueprint $table) {
            $table->id();
            $table->string('name',50);
            $table->string('phone',15)->unique();
            $table->string('additional_phone',15)->nullable();
            $table->string('email')->nullable();
            $table->string('avatar')->nullable();
            $table->enum('type',['1','2'])->default('1')->comment = "1=Active, 2=Inactive";
            $table->unsignedBigInteger('depo_id')->nullable();
            $table->foreign('depo_id')->references('id')->on('depos');
            $table->unsignedBigInteger('district_id');
            $table->foreign('district_id')->references('id')->on('locations');
            $table->unsignedBigInteger('upazila_id');
            $table->foreign('upazila_id')->references('id')->on('locations');
            $table->string('nid_no')->nullable();
            $table->double('monthly_target_value')->nullable();
            $table->text('address')->nullable();
            $table->enum('status',['1','2'])->default('1')->comment = "1=Active, 2=Inactive";
            $table->string('created_by')->nullable();
            $table->string('modified_by')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('salesmen');
    }
}