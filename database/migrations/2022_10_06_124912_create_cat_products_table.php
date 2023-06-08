<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cat_products', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->string('slug', 150);
            $table->integer('parent_id');
            $table->string('status', 100);
            $table->integer('has_child')->nullable();
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
        Schema::dropIfExists('cat_products');
    }
}
