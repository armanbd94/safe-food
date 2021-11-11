<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderSheetProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_sheet_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_sheets_id');
            $table->foreign('order_sheets_id')->references('id')->on('order_sheets');
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products');
            $table->float('stock_qty');
            $table->float('ordered_qty');
            $table->float('required_qty');
            $table->float('total');
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
        Schema::dropIfExists('order_sheet_products');
    }
}
