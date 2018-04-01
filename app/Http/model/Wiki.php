<?php

namespace App\Http\model;

use Illuminate\Database\Eloquent\Model;

/**
 * WIKI模型
 * @package App\Http\model
 */
class Wiki extends Model
{
    const table = 'blade_wiki';
    const tableWithDot = 'blade_wiki.';

    /**
     * 与模型关联的数据表
     * @var string
     */
    protected $table = 'blade_wiki';

    protected $primaryKey = 'id';
}
