<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('supplier_id');
            $table->integer('brand_id');
            $table->integer('category_id');
            $table->string('name');
            $table->text('details');
            $table->string('description');
            $table->string('seo_keywords');
            $table->string('seo_description');
            $table->string('label');
            $table->text('public_attr');
            $table->timestamps();
        });

        Schema::create('product_sub', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id');
            $table->string('productNo');
            $table->decimal('price',10,2);
            $table->decimal('sale_price',10,2);
            $table->string('image');
            $table->tinyInteger('review');
            $table->tinyInteger('is_show');
            $table->string('sort_order');
            $table->text('private_attr');
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
        Schema::drop('product');
        Schema::drop('product_sub');
    }
}
