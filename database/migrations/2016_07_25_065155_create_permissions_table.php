<?php
// 权限表管理
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //  权限表
        Schema::create('permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pid');
            $table->string('name');
            $table->string('label');
            $table->string('url');
            $table->string('description')->nullable();
            $table->tinyInteger('is_display');
            $table->string('sort_order');
            $table->timestamps();
        });

        // 权限和权限组关联表
        Schema::create('permission_role',function(Blueprint $table){
            $table->integer('permission_id')->unsigned();
            $table->integer('role_id')->unsigned();

            $table->foreign('permission_id')
                  ->references('id')
                  ->on('permissions')
                  ->onDelete('cascade');

            $table->foreign('role_id')
                  ->references('id')
                  ->on('roles')
                  ->onDelete('cascade');
            $table->primary(['permission_id','role_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('permissions');
        Schema::drop('permissions_role');
    }
}
