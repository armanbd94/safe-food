<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderSheetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_sheets', function (Blueprint $table) {
            $table->id();
            $table->string('sheet_no')->unique();
            $table->date('order_date');
            $table->float('item');
            $table->float('total_qty');
            $table->float('total');
            $table->float('total_commission')->nullable();
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
        Schema::dropIfExists('order_sheets');
    }
}