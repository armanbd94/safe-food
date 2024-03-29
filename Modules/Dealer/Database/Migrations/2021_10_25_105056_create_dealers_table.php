<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->string('name',100);
            $table->string('mobile_no',15)->unique();
            $table->string('email')->nullable();
            $table->unsignedBigInteger('depo_id')->nullable();
            $table->foreign('depo_id')->references('id')->on('depos');
            $table->unsignedBigInteger('district_id');
            $table->foreign('district_id')->references('id')->on('locations');
            $table->unsignedBigInteger('upazila_id');
            $table->foreign('upazila_id')->references('id')->on('locations');
            $table->unsignedBigInteger('area_id');
            $table->foreign('area_id')->references('id')->on('locations');
            $table->text('address')->nullable();
            $table->float('commission_rate')->nullable();
            $table->enum('type',['1','2'])->comment = "1=Depo Dealer, 2=Direct Dealer";
            $table->unsignedBigInteger('dealer_group_id')->nullable();
            $table->foreign('dealer_group_id')->references('id')->on('dealer_groups');
            $table->enum('status',['1','2'])->default('1')->comment = "1=Active, 2=Inactive";
            $table->string('created_by')->nullable();
            $table->string('modified_by')->nullable();
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
        Schema::dropIfExists('dealers');
    }
}
