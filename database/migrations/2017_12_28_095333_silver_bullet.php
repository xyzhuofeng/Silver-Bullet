<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SilverBullet extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blade_account', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('user_id')->comment('用户id');
            $table->string('email')->comment('用户邮箱');
            $table->string('user_name')->comment('用户名');
            $table->char('user_password', 60)->comment('密码密文');
            $table->string('user_avatar')->comment('用户头像');
            $table->rememberToken(); // 加入 remember_token 并使用 VARCHAR(100) NULL。
            $table->timestamps(); // 加入 created_at 和 updated_at 字段。
        });
        Schema::create('blade_password_resets', function (Blueprint $table) {
            $table->bigIncrements('resets_id')->commet('重置密码id');
            $table->string('email')->commet('邮箱');
            $table->string('token')->commet('密钥');
            $table->timestamps();
        });
        Schema::create('blade_project', function (Blueprint $table) {
            $table->bigIncrements('project_id')->comment('项目id');
            $table->string('project_name', 20)->comment('项目名称');
            $table->text('project_comment')->nullable()->comment('项目备注');
            $table->unsignedBigInteger('creator')->comment('项目创建者');
            $table->text('project_thumb')->nullable()->comment('项目图标图片');
            $table->timestamps();
        });
        Schema::create('blade_project_user', function (Blueprint $table) {
            $table->unsignedBigInteger('project_id')->comment('项目id');
            $table->unsignedBigInteger('user_id')->comment('用户id');
            $table->primary(['project_id', 'user_id']);
            $table->string('role',20)->comment('用户角色，creator/manager/normal');
            $table->timestamps();
        });
        Schema::create('blade_task', function (Blueprint $table) {
            $table->bigIncrements('task_id')->comment('任务id');
            $table->text('task_content')->comment('任务内容');
            $table->bigInteger('creator')->comment('创建者');
            $table->bigInteger('project_id')->comment('项目id');
            $table->tinyInteger('is_finished')->comment('完成标识，1完成/0未完成');
            $table->timestamp('deadline')->nullable()->comment('截止时间');
            $table->timestamps();
        });
        Schema::create('blade_task_user', function (Blueprint $table) {
            $table->bigInteger('task_id')->comment('任务id');
            $table->bigInteger('user_id')->comment('用户id');
            $table->primary(['task_id', 'user_id']);
            $table->string('role', 20)->comment('用户角色，creator/manager/normal');
            $table->timestamps();
        });
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
        Schema::dropIfExists('blade_account');
        Schema::dropIfExists('blade_password_resets');
        Schema::dropIfExists('blade_project');
        Schema::dropIfExists('blade_project_user');
        Schema::dropIfExists('blade_task');
        Schema::dropIfExists('blade_task_user');
        Schema::dropIfExists('blade_project_file');
        Schema::dropIfExists('blade_dir_structure');
    }
}
