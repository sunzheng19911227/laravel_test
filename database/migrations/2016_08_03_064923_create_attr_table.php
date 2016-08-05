<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttrTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attr', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->tinyInteger('input_box_type');
            $table->tinyInteger('input_value_type');
            $table->tinyInteger('status');
            $table->integer('sort_order');
            $table->timestamps();
        });

        Schema::create('attr_value', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->tinyInteger('status');
            $table->integer('sort_order');
            $table->timestamps();
        });

        Schema::create('attr_attr_value', function (Blueprint $table) {
            $table->integer('attr_id')->unsigned();
            $table->integer('attr_value_id')->unsigned();

            $table->foreign('attr_id')
                  ->references('id')
                  ->on('attr')
                  ->onDelete('cascade');

            $table->foreign('attr_value_id')
                  ->references('id')
                  ->on('attr_value')
                  ->onDelete('cascade');
            $table->primary(['attr_id','attr_value_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('attr');
        Schema::drop('attr_value');
        Schema::drop('attr_attribute_value');
    }
}
