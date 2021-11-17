<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSaleReturnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_returns', function (Blueprint $table) {
            $table->id();
            $table->string('return_no')->unique();
            $table->unsignedBigInteger('sale_id')->nullable();
            $table->foreign('sale_id')->references('id')->on('sales');
            $table->float('item');
            $table->float('total_qty');
            $table->double('total_price');
            $table->double('total_deduction')->nullable();
            $table->double('grand_total');
            $table->text('reason')->nullable();
            $table->date('return_date');
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
        Schema::dropIfExists('sale_returns');
    }
}
