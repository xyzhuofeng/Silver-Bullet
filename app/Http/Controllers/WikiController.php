<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * WIKI
 * @package App\Http\Controllers
 */
class WikiController
{
    /**
     * wiki首页
     * @param Request $request
     * @param $project_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request, $project_id)
    {

        return view('wiki.index',[

        ]);
    }
}
