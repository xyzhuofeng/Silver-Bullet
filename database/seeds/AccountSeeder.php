<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * 用户表种子发生器
 */
class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('blade_account')->insert([
            'email' => '469379004@qq.com',
            'user_name' => '庆爷',
            'user_password' => \hyperqing\Password::crypt('123456'),
            'user_avatar' => 'app/avatar/男.png',
            'job' => '项目经理',
            'created_at' => '2017-12-03 15:46:27',
            'updated_at' => '2017-12-03 15:46:27'
        ]);
    }
}
