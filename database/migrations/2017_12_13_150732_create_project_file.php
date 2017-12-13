<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * 创建项目文件表
 */
class CreateProjectFile extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blade_project_file', function (Blueprint $table) {
            $table->bigIncrements('file_id')->comment('文件id');
            $table->bigInteger('creator')->comment('文件创建者id');
            $table->bigInteger('project_id')->comment('项目id');
            $table->text('virtual_path')->comment('文件虚拟路径，如“全部文件/项目文件”');
            $table->string('real_name', 255)->comment('真实文件名');
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
        Schema::dropIfExists('blade_project_file');
    }
}
