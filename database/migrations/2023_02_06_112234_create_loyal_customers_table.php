<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoyalCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loyal_customers', function (Blueprint $table) {
            $table->id();
            $table->string('fullname', 100);
            $table->string('email', 100);
            $table->string('phone', 100);
            $table->string('address', 100);
            $table->string('wards', 150);
            $table->string('province', 150);
            $table->string('city', 150);
            $table->string('card_total', 100);
            $table->string('bought_recently', 100);
            $table->string('number_order', 100);
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
        Schema::dropIfExists('loyal_customers');
    }
}
