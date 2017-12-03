<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * 创建项目用户关联表
 */
class CreateProjUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blade_project_user', function (Blueprint $table) {
            $table->unsignedBigInteger('project_id')->comment('项目id');
            $table->unsignedBigInteger('user_id')->comment('用户id');
            $table->primary(['project_id', 'user_id']);
            $table->string('role',20)->comment('用户角色，creator/manager/normal');
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
        Schema::dropIfExists('blade_project_user');
    }
}
