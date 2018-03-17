<?php

namespace App\Http\Middleware;

use App\Http\model\Project;
use Closure;

/**
 * 用于渲染模板变量的中间件
 * @package App\Http\Middleware
 */
class ViewTempleteVal
{
    // 项目名称和id，可用于视图输出
    public static $projectName = '';
    public static $projectId = '';

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (isset($request->route()->parameters['project_id'])) {
            $project = Project::where('project_id', $request->route()->parameters['project_id'])->first();
            self::$projectName = $project->project_name;
            self::$projectId = $project->project_id;
        }
        return $next($request);
    }
}
