<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('js/fonts.googleapis.com.css') }}">
    <link rel="stylesheet" href="{{ asset('js/element-ui/2.0.5/theme-chalk/index.css') }}">
    <link rel="stylesheet" href="{{ asset('js/public.css') }}">
    <script src="{{ asset('js/vue.js') }}"></script>
    <script src="{{ asset('js/element-ui/2.0.5/index.js') }}"></script>
    <script src="{{ asset('js/axios/0.17.1/axios.min.js') }}"></script>
    <title>银弹 - 您的团队协作平台</title>
    <style>
        .container {
            width: 100%;
            max-width: 1000px;
            margin: 0 auto;
        }

        h1, h3 {
            margin: 0;
        }

        html, body {
            background: #fff;
            font-family: "Helvetica Neue", Helvetica, "PingFang SC", "Hiragino Sans GB", "Microsoft YaHei", "微软雅黑", Arial, sans-serif;
        }

        .page {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        header {
            height: 50px;
            padding: 25px;
        }

        header:after {
            display: block;
            content: ' ';
            clear: both;
        }

        .silver {
            font-size: 22px;
            color: #555;
            font-family: 'Raleway', sans-serif;
        }

        header a.el-button--text {
            font-size: 18px;
        }

        main {
            flex: 1;
            margin-top: 200px;
            text-align: center;
            color: #222;
        }

        main h1, main h3 {
            margin-bottom: 20px;
            font-weight: lighter;
            font-size: 40px;
        }

        main h3 {
            font-weight: bold;
            font-size: 25px;
            color: #2a2a2a;
        }

        main .el-button {
            width: 200px;
            font-size: 25px;
        }

        footer {
            margin: 20px 0;
            text-align: center;
            color: #888;
        }

    </style>
</head>
<body>
<div id="app">
    <div class="page">
        <header>
            <div class="container">
                <div class="pull-left">
                    <a href="{{ url('/') }}" class="el-button el-button--text">
                        <h3 class="silver">Silver Bullet</h3>
                    </a>
                </div>
                <div class="pull-right">
                    <a href="{{ url('project') }}" class="el-button el-button--text">进入项目中心</a>
                </div>
            </div>
        </header>
        <main>
            <div class="container">
                <h1>银弹 - 属于你的协作平台</h1>
                <h3>专为小型开发团队设计</h3>
                <el-button type="primary" @click="goto('{{ url("project") }}')">立即开始</el-button>
            </div>
        </main>
        <footer>
            Copyright &copy; 2017 Designed by HyperQing
        </footer>
    </div>
</div>
</body>
<script>
    let app = new Vue({
        el: "#app",
        methods: {
            goto: function (url) {
                window.location.href = url;
            }
        }
    })
</script>
</html>
