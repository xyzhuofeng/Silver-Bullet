<?php

namespace App\Http\model;

use Illuminate\Database\Eloquent\Model;

/**
 * 项目文件模型
 * @package App\Http\model
 */
class ProjectFile extends Model
{
    /**
     * 与模型关联的数据表
     *
     * @var string
     */
    public $table = 'blade_project_file';

    // 禁用自增主键
    public $incrementing = false;

    protected $primaryKey = 'file_id';
}