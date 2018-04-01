<?php

namespace App\Http\Controllers;

use App\Http\model\Wiki;
use Illuminate\Http\Request;

/**
 * WIKI
 * @package App\Http\Controllers
 */
class WikiController
{
    /**
     * wiki首页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('wiki.index');
    }

    public function article(Request $request, $project_id)
    {
        $wiki = Wiki::where('project_id', $project_id)
            ->first();
        return response()->json([
            'status' => 1,
            'info' => '获取成功',
            'data' => $wiki
        ]);
    }

    /**
     * 保存wiki
     * @param Request $request
     * @param $project_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function save(Request $request, $project_id)
    {
        $title = $request->post('title', '');
        $content = $request->post('content', '');
        if (empty($title)) {
            $title = '';
        }
        if (empty($content)) {
            $content = '';
        }
        $wiki = Wiki::where('project_id', $project_id)
            ->first();
        if (!$wiki) {
            $wiki = new Wiki();
        }
        $wiki->setAttribute('project_id', $project_id);
        $wiki->setAttribute('user_id', session('user_id'));
        $wiki->setAttribute('title', $title);
        $wiki->setAttribute('content', $content);
        $wiki->setAttribute('created_at', date('Y-m-d H:i:s'));
        $wiki->setAttribute('updated_at', date('Y-m-d H:i:s'));
        if ($wiki->save()) {
            return response()->json([
                'status' => 1,
                'info' => '保存成功',
            ]);
        }
        return response()->json([
            'status' => 0,
            'info' => '保存失败',
        ]);

    }
}
