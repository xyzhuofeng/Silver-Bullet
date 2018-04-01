<?php

namespace App\Http\model;

use Illuminate\Database\Eloquent\Model;

/**
 * 项目动态
 * @package App\Http\model
 */
class Timeline extends Model
{
    const table = 'blade_timeline';
    const tableWithDot = 'blade_timeline.';

    /**
     * 与模型关联的数据表
     *
     * @var string
     */
    protected $table = 'blade_timeline';

    protected $primaryKey = 'id';
}
