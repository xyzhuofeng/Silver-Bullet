<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blade_project', function (Blueprint $table) {
            $table->bigIncrements('project_id')->comment('项目id');
            $table->string('project_name', 20)->comment('项目名称');
            $table->text('project_comment')->comment('项目备注');
            $table->bigInteger('creator')->comment('项目创建者');
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
        Schema::dropIfExists('blade_project');
    }
}
