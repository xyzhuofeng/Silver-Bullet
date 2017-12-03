<?php

namespace App\Http\model;

use Illuminate\Database\Eloquent\Model;

/**
 * 项目用户关联表模型
 * @package App\Http\model
 */
class ProjectUser extends Model
{
    /**
     * 与模型关联的数据表
     *
     * @var string
     */
    protected $table = 'blade_project_user';

    protected $primaryKey = 'project_id';
}
