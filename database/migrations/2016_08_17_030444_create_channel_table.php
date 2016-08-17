<?php
// 商品销售渠道迁移文件
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChannelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //  商品销售渠道表
        Schema::create('channel', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->tinyInteger('is_sync');
            $table->timestamps();
        });

        //  关联商品表
        Schema::create('channel_product_sub', function (Blueprint $table) {
            $table->integer('channel_id')->unsigned();
            $table->integer('product_id')->unsigned();

            $table->foreign('channel_id')
                  ->references('id')
                  ->on('channel')
                  ->onDelete('cascade');

            $table->foreign('product_id')
                  ->references('id')
                  ->on('product_sub')
                  ->onDelete('cascade');
            $table->primary(['channel_id','product_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('channel');
        Schema::drop('channel_product_sub');
    }
}
