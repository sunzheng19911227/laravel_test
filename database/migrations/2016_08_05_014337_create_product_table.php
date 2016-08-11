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
            $table->integer('supplier_id')->index();
            $table->integer('brand_id')->index();
            $table->integer('category_id')->index();
            $table->string('name')->index();
            $table->text('details')->default('');
            $table->string('description')->default('');
            $table->string('seo_keywords')->default('');
            $table->string('seo_description')->default('');
            $table->string('label')->default('');
            $table->text('public_attr')->default('');
            $table->timestamps();
            $table->softDeletes();   // 软删除字段
        });

        Schema::create('product_sub', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id');
            $table->string('productNo')->uniqid();
            $table->decimal('price', 10, 2)->default('0.00');
            $table->decimal('sale_price', 10, 2)->default('0.00');
            $table->string('image');
            $table->tinyInteger('review');
            $table->tinyInteger('is_show');
            $table->string('sort_order');
            $table->text('private_attr');
            $table->timestamps();
            $table->softDeletes();    // 软删除字段
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
