<?php

namespace App\Http\model;

use Illuminate\Database\Eloquent\Model;

class TaskUser extends Model
{
    const table = 'blade_task_user';
    const tableWithDot = 'blade_task_user.';

    /**
     * 与模型关联的数据表
     *
     * public供外部读取表名
     * @var string
     */
    protected $table = 'blade_task_user';

    protected $primaryKey = 'task_id';
}
