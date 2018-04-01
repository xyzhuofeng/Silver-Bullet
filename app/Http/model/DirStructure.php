<?php

namespace App\Http\model;

use Illuminate\Database\Eloquent\Model;

/**
 * 目录结构表模型
 * @package App\Http\model
 */
class DirStructure extends Model
{
    const table = 'blade_dir_structure';
    const tableWithDot = 'blade_dir_structure.';

    /**
     * 与模型关联的数据表
     *
     * public供外部读取表名
     * @var string
     */
    public $table = 'blade_dir_structure';

    protected $primaryKey = 'structure_id';
}
