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
            $table->text('relative_path')->comment('真实相对路径');
            $table->string('original_name', 255)->comment('原始文件名');
            $table->text('hash_name')->comment('Hash文件名');
            $table->text('file_ext')->comment('文件后缀，单位字节');
            $table->text('file_size')->comment('文件大小，单位字节');
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
