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
     * @var string
     */
    protected $table = 'blade_timeline';

    protected $primaryKey = 'id';

    /**
     * 任务动态
     * @param $project_id
     * @param $task_content
     * @param string $operate
     */
    public static function task($project_id, $task_content, $operate = '创建')
    {
        $task_content = mb_substr($task_content, 0, 20);
        $timeline = new Timeline();
        $timeline->setAttribute('user_id', session('user_id'));
        $timeline->setAttribute('project_id', $project_id);
        $timeline->setAttribute('content', $operate . '了任务<span class="sb-timeline-text">' . $task_content . '</span>');
        $timeline->save();
    }


    /**
     * 通过项目id获取项目动态
     * @param $project_id
     * @return array
     */
    public static function listByProject_id($project_id)
    {
        return Timeline::join(Account::table,
            Account::tableWithDot . 'user_id', '=', Timeline::tableWithDot . 'user_id'
        )
            ->where(Timeline::tableWithDot . 'project_id', $project_id)
            ->orderBy(Timeline::tableWithDot . 'created_at', 'desc')
            ->get();
    }
}
