<?php

namespace App\Http\model;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    const table = 'blade_task';
    const tableWithDot = 'blade_task.';

    /**
     * 与模型关联的数据表
     *
     * public供外部读取表名
     * @var string
     */
    public $table = 'blade_task';

    protected $primaryKey = 'task_id';
}
