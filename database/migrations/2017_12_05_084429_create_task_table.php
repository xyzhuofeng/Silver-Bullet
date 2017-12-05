<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * 创建项目任务表
 */
class CreateTaskTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blade_task_table', function (Blueprint $table) {
            $table->bigIncrements('task_id')->comment('任务id');
            $table->text('task_content')->comment('任务内容');
            $table->bigInteger('creator')->comment('创建者');
            $table->bigInteger('project_id')->comment('项目id');
            $table->tinyInteger('is_finished')->comment('完成标识，1完成/0未完成');
            $table->timestamp('deadline')->comment('截止时间');
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
        Schema::dropIfExists('blade_task_table');
    }
}
