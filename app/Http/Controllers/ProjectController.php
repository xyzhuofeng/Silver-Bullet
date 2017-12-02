<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

    /**
     * 创建项目信息
     *
     * POST
     * @param Request $request
     */
    public function save(Request $request)
    {

    }

    /**
     * 获取指定项目信息
     *
     * GET
     * @param Request $request
     */
    public function read(Request $request)
    {
        $project_id = $request->get('project_id');
    }

    /**
     * 编辑项目信息页面
     */
    public function edit(Request $request){
        $project_id = $request->get('project_id');

    }

    /**
     * 更新项目信息
     *
     * PUT
     * @param Request $request
     */
    public function update(Request $request){
        $project_id = $request->input('project_id');
    }

    /**
     * 删除项目
     *
     * DELETE
     * @param Request $request
     */
    public function delete(Request $request){

    }
}
