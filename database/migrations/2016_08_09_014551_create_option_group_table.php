<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOptionGroupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 选项组表
        Schema::create('option_group', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->tinyInteger('status');
            $table->string('sort_order');
            $table->timestamps();
        });

        // 选项组和属性关联表
        Schema::create('option_group_attr',function(Blueprint $table){
            $table->integer('option_group_id')->unsigned();
            $table->integer('attr_id')->unsigned();

            $table->foreign('option_group_id')
                  ->references('id')
                  ->on('option_group')
                  ->onDelete('cascade');

            $table->foreign('attr_id')
                  ->references('id')
                  ->on('attr')
                  ->onDelete('cascade');
            $table->primary(['option_group_id','attr_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('option_group');
        Schema::drop('option_group_attr');
    }
}
