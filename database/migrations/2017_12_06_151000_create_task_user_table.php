<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * 任务用户关联表
 */
class CreateTaskUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blade_task_user', function (Blueprint $table) {
            $table->bigInteger('task_id')->comment('任务id');
            $table->bigInteger('user_id')->comment('用户id');
            $table->primary(['task_id', 'user_id']);
            $table->string('role', 20)->comment('用户角色，creator/manager/normal');
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
        Schema::dropIfExists('blade_task_user');
    }
}
