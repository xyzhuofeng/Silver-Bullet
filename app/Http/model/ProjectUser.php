<?php

namespace App\Http\model;

use App\Traits\HasCompositePrimaryKey;
use Illuminate\Database\Eloquent\Model;

/**
 * 项目用户关联表模型
 * @package App\Http\model
 */
class ProjectUser extends Model
{
    use HasCompositePrimaryKey;
    const table = 'blade_project_user';
    const tableWithDot = 'blade_project_user.';

    /**
     * 与模型关联的数据表
     *
     * @var string
     */
    public $table = 'blade_project_user';

    // 禁用自增主键
    public $incrementing = false;

    protected $primaryKey = ['project_id', 'user_id'];
}
