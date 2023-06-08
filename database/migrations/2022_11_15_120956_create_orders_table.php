<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('fullname', 100);
            $table->string('email', 100);
            $table->string('phone', 100);
            $table->string('address', 100);
            $table->string('wards', 150);
            $table->string('province', 150);
            $table->string('city', 150);
            $table->string('note', 100)->nullable();
            $table->string('payment_method', 100);
            $table->string('code', 100);
            $table->string('card_total', 100);
            $table->text('product_order');
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
        Schema::dropIfExists('orders');
    }
}
