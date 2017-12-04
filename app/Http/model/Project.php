<?php

namespace App\Http\model;

use Illuminate\Database\Eloquent\Model;

/**
 * 项目表模型
 * @package App\Http\model
 */
class Project extends Model
{
    /**
     * 与模型关联的数据表
     *
     * public供外部读取表名
     * @var string
     */
    public $table = 'blade_project';

    protected $primaryKey = 'project_id';
}
