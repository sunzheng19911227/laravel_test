<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttrGroupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 属性组表
        Schema::create('attr_group', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->tinyInteger('status');
            $table->string('sort_order');
            $table->timestamps();
        });

        // 属性组和属性关联表
        Schema::create('attr_group_attr',function(Blueprint $table){
            $table->integer('attr_group_id')->unsigned();
            $table->integer('attr_id')->unsigned();

            $table->foreign('attr_group_id')
                  ->references('id')
                  ->on('attr_group')
                  ->onDelete('cascade');

            $table->foreign('attr_id')
                  ->references('id')
                  ->on('attr')
                  ->onDelete('cascade');
            $table->primary(['attr_group_id','attr_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('attr_group');
        Schema::drop('attr_group_attr');
    }
}
