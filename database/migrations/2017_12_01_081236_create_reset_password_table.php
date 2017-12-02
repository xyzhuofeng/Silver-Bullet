<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * 创建密码重置表
 * Class CreateResetPasswordTable
 */
class CreateResetPasswordTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blade_password_resets', function (Blueprint $table) {
            $table->bigIncrements('resets_id')->commet('重置密码id');
            $table->string('email')->commet('邮箱');
            $table->string('token')->commet('密钥');
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blade_password_resets');
    }
}
