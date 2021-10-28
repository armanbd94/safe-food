<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('memo_no')->unique()->index('memo_no');
            $table->enum('order_from',['1','2'])->comment="1=Depo,2=Direct Dealer";
            $table->unsignedBigInteger('depo_id')->nullable();
            $table->foreign('depo_id')->references('id')->on('depos');
            $table->unsignedBigInteger('dealer_id')->nullable();
            $table->foreign('dealer_id')->references('id')->on('dealers');
            $table->unsignedBigInteger('district_id');
            $table->foreign('district_id')->references('id')->on('locations');
            $table->unsignedBigInteger('upazila_id');
            $table->foreign('upazila_id')->references('id')->on('locations');
            $table->unsignedBigInteger('area_id');
            $table->foreign('area_id')->references('id')->on('locations');
            $table->float('item');
            $table->float('total_qty');
            // $table->double('total_discount');
            // $table->double('total_tax');
            $table->double('total_price');
            // $table->double('order_tax_rate')->nullable();
            // $table->double('order_tax')->nullable();
            // $table->double('order_discount')->nullable();
            // $table->double('shipping_cost')->nullable();
            // $table->double('labor_cost')->nullable();
            $table->double('grand_total');
            $table->double('previous_due')->nullable();
            $table->double('net_total')->nullable();
            $table->double('paid_amount')->nullable();
            $table->double('due_amount')->nullable();
            $table->float('commission_rate')->nullable()->comment('Commission Rate(%)');
            $table->double('total_commission')->nullable()->comment('Total Commission');
            $table->enum('payment_status',['1','2','3'])->comment="1=Paid,2=Partial,3=Due";
            $table->enum('payment_method',['1','2','3'])->nullable()->comment="1=Cash,2=Bank,3=Mobile Bank";
            $table->unsignedBigInteger('account_id')->nullable();
            $table->foreign('account_id')->references('id')->on('chart_of_accounts');
            $table->text('reference_no')->nullable();
            $table->string('document')->nullable();
            $table->text('note')->nullable();
            $table->date('sale_date');
            $table->enum('delivery_status',['1','2'])->default(1)->comment="1=Pending,2=Delivered";
            $table->date('delivery_date')->nullable();
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
        Schema::dropIfExists('sales');
    }
}
