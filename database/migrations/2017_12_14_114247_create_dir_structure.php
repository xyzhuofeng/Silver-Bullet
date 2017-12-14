<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * 创建目录结构表迁移类
 */
class CreateDirStructure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blade_dir_structure', function (Blueprint $table) {
            $table->bigIncrements('structure_id')->comment('结构id');
            $table->bigInteger('project_id')->comment('项目id');
            $table->json('structure')->comment('目录结构json');
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
        Schema::dropIfExists('blade_dir_structure');
    }
}
