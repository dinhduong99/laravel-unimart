<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->string('slug', 150);
            $table->string('thumbnail', 150);
            $table->foreignId('product_cat_id')->nullable()->constrained('cat_products')->onDelete('cascade');
            $table->unsignedInteger('price');
            $table->unsignedInteger('percent_price');
            $table->unsignedInteger('sale_price');
            $table->text('detail');
            $table->text('description');
            $table->string('status', 100);
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
        Schema::dropIfExists('products');
    }
}
