<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * 创建用户表
 */
class CreateAccountTable extends Migration
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
            $table->rememberToken(); // 加入 remember_token 并使用 VARCHAR(100) NULL。
            $table->timestamps(); // 加入 created_at 和 updated_at 字段。
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('blade_account', function (Blueprint $table) {
            //
        });

        Schema::dropIfExists('blade_account');
    }
}
