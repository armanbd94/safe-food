<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDealerGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *php
     * @return void
     */
    public function up()
    {
        Schema::create('dealer_groups', function (Blueprint $table) {
            $table->id();
            $table->string('group_name')->unique();
            $table->enum('status',['1','2'])->default('1')->comment="1=active,2=inactive";
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
        Schema::dropIfExists('customer_groups');
    }
}
