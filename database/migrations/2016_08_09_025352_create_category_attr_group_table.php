<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryAttrGroupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //  类型和属性组关联表
        Schema::create('category_attr_group',function(Blueprint $table){
            $table->integer('category_id')->unsigned();
            $table->integer('attr_group_id')->unsigned();

            $table->foreign('category_id')
                  ->references('id')
                  ->on('category')
                  ->onDelete('cascade');

            $table->foreign('attr_group_id')
                  ->references('id')
                  ->on('attr_group')
                  ->onDelete('cascade');
            $table->primary(['category_id','attr_group_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('category_attr_group');
    }
}
