<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOpeningStockProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('opening_stock_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('opening_stock_id');
            $table->foreign('opening_stock_id')->references('id')->on('opening_stocks');
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products');
            $table->unsignedBigInteger('base_unit_id')->nullable();
            $table->foreign('base_unit_id')->references('id')->on('units');
            $table->double('base_unit_qty');
            $table->double('base_unit_price');
            $table->double('tax_rate');
            $table->double('tax');
            $table->double('total');
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
        Schema::dropIfExists('opening_stock_products');
    }
}
