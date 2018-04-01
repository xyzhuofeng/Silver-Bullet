<script>
    // 导航条子组件数据
    let headerData = {
        defaultActive: "abc",
        homeUrl: "{{ url('/') }}",
        username: "{{ session('user_name') }}",
        avatarUrl: "{{ session('user_avatar') }}",
        logoutUrl: "{{ url('passport/logout') }}",
        projectName: "{{ \App\Http\Middleware\ViewTempleteVal::$projectName }}",
        usercenterUrl: "{{ url('user') }}",
        projectUrl: "{{ url('project') }}",
    };

    // 二级导航数据
    let secondNavData = {
        defaultActive: "", // 需要在mounted方法中赋值
        summary: "{{ url('project', \App\Http\Middleware\ViewTempleteVal::$projectId) }}", // 看板
        task: "{{ route('task/index', \App\Http\Middleware\ViewTempleteVal::$projectId) }}", // 任务
        wiki: "{{ route('wiki/index', \App\Http\Middleware\ViewTempleteVal::$projectId) }}", // wiki
        file: "{{ route('file/index', \App\Http\Middleware\ViewTempleteVal::$projectId) }}", // 文件
        setting: "{{ route('project/setting', \App\Http\Middleware\ViewTempleteVal::$projectId) }}", // 项目设置
    };

    // 任务组件数据
    let taskItemData = {
        project_id: "{{ \App\Http\Middleware\ViewTempleteVal::$projectId }}",
        task_type: "all",
        myTaskUrl: "{{ route('task/my', ['protect_id'=>\App\Http\Middleware\ViewTempleteVal::$projectId]) }}",
        unfinishTaskUrl: "{{ route('task/unfinish', ['protect_id'=>\App\Http\Middleware\ViewTempleteVal::$projectId]) }}",
        createTaskUrl: "{{ route('task/save', \App\Http\Middleware\ViewTempleteVal::$projectId) }}",
        finishTaskUrl: "{{ route('task/finish', \App\Http\Middleware\ViewTempleteVal::$projectId) }}",
        deleteTaskUrl: "{{ route('task/delete', \App\Http\Middleware\ViewTempleteVal::$projectId) }}",
        getMemberListUrl: "{{ route('member/index', \App\Http\Middleware\ViewTempleteVal::$projectId) }}",
    };
</script>