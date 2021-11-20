<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGuestGiftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guest_gifts', function (Blueprint $table) {
            $table->id();
            $table->string('voucher_no')->unique()->index('voucher_no');
            $table->string('guest_name',100);
            $table->string('gift_from',100);
            $table->float('item');
            $table->float('total_qty');
            $table->text('note')->nullable();
            $table->date('date');
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
        Schema::dropIfExists('guest_gifts');
    }
}
