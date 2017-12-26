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
    public static $projectName = '';

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
        }
        return $next($request);
    }
}
