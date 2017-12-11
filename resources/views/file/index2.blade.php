<!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>文件 - 从心约App - 团队协作平台</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ url(mix('css/app.css')) }}">
    <style>
        [v-cloak] {
            display: none;
        }

        /*整页采用flex纵向布局，实现页脚自适应*/
        .page {
            display: flex;
            flex-direction: column;
            height: 100%;
            min-height: 100vh;
        }
    </style>
</head>
<body>
<div id="app" v-cloak>
    <div class="page">
        <header-nav :header-data="headerData"></header-nav>
    </div>
    <file-explorer></file-explorer>
</div>
</body>
<script src="{{ url(mix('js/app.js')) }}"></script>
<script>
    new Vue({
        el: '#app',
        data() {
            return {
                // 传给子组件数据
                // 页头
                headerData: {
                    avatarUrl: "{{ asset('images/男.png') }}",
                    logoutUrl: "{{ url('passport/logout') }}"
                }
            }
        }
    })
</script>
</html>