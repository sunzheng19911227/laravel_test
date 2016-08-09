<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryOptionGroupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //  类型和属性组关联表
        Schema::create('category_option_group',function(Blueprint $table){
            $table->integer('category_id')->unsigned();
            $table->integer('option_group_id')->unsigned();

            $table->foreign('category_id')
                  ->references('id')
                  ->on('category')
                  ->onDelete('cascade');

            $table->foreign('option_group_id')
                  ->references('id')
                  ->on('option_group')
                  ->onDelete('cascade');
            $table->primary(['category_id','option_group_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('category_option_group');
    }
}
