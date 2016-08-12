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
            $table->integer('supplier_id')->index()->change();
            $table->integer('brand_id')->index()->change();
            $table->integer('category_id')->index()->change();
            $table->string('name')->index()->change();
            $table->text('details')->default('')->change();
            $table->string('description')->default('')->change();
            $table->string('seo_keywords')->default('')->change();
            $table->string('seo_description')->default('')->change();
            $table->string('label')->default('')->change();
            $table->text('public_attr')->default('')->change();
            $table->timestamps();
            $table->softDeletes();   // 软删除字段
        });

        Schema::create('product_sub', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id');
            $table->string('productNo')->uniqid()->change();
            $table->decimal('price', 10, 2)->default('0.00')->change();
            $table->decimal('sale_price', 10, 2)->default('0.00')->change();
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
