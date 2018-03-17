<script>
    // 导航条子组件数据
    let headerData = {
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
        requirement: "{{url('/')}}", // 需求
        file: "{{ route('file/index', \App\Http\Middleware\ViewTempleteVal::$projectId) }}", // 文件
        setting: "{{ route('project/setting', \App\Http\Middleware\ViewTempleteVal::$projectId) }}", // 项目设置
    };
</script>