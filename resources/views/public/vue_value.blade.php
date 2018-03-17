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
</script>