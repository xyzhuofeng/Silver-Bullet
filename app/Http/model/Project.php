<?php

namespace App\Http\model;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    /**
     * 与模型关联的数据表
     *
     * @var string
     */
    protected $table = 'blade_project';

    protected $primaryKey = 'project_id';
}
