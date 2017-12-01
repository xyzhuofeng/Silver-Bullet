<?php
/**
 * Created by PhpStorm.
 * User: Li
 * Date: 2017/11/30
 * Time: 10:12
 */

namespace App\Http\Controllers;

/**
 * 项目控制器
 * @package App\Http\Controllers
 */
class ProjectController
{
    /**
     * 项目首页
     */
    public function index()
    {
        return view('project.index');
    }
}
