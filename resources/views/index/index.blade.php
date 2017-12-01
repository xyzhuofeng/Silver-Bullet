<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>银弹 - 您的团队协作平台</title>
    <script src="https://cdn.bootcss.com/vue/2.5.8/vue.min.js"></script>
    <script src="https://cdn.bootcss.com/element-ui/2.0.5/index.js"></script>
    <link href="https://cdn.bootcss.com/element-ui/2.0.5/theme-chalk/index.css" rel="stylesheet">
    <script src="https://cdn.bootcss.com/axios/0.17.1/axios.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    <title>Laravel</title>
    <style>
        header:after {
            display: block;
            content: ' ';
            clear: both;
        }

        .pull-left {
            float: left;
        }

        .pull-right {
            float: right;
        }

        .container {
            width: 1000px;
            margin: 0 auto;
        }

        h1, h3 {
            margin: 0;
        }

        html, body {
            height: 100%;
            width: 100%;
            margin: 0;
            padding: 0;
            background: #f7fafc;
        }

        header {
            height: 50px;
            padding: 25px;
        }

        header h3 {
            font-family: "Helvetica Neue", Helvetica, "PingFang SC", "Hiragino Sans GB", "Microsoft YaHei", "微软雅黑", Arial, sans-serif;
        }

        header a {
            display: inline-block;
            color: #09f;
            text-decoration: none;
        }

        header a + a {
            margin-left: 15px;
        }

        .content {
            margin-top: 200px;
            text-align: center;
            color: #2a2a2a;
            font-family: "Helvetica Neue", Helvetica, "PingFang SC", "Hiragino Sans GB", "Microsoft YaHei", "微软雅黑", Arial, sans-serif;
        }


        .content h1, .content h3 {
            margin-bottom: 20px;
            font-weight: lighter;
            font-size: 40px;
        }
        .content h3{
            font-weight: bold;
            font-size: 25px;
        }

        footer {
            position: fixed;
            bottom: 20px;
            width: 100%;
            margin: 0 auto;
            text-align: center;
            color: #888;
        }

    </style>
</head>
<body>
<div id="app">
    <header>
        <div class="container">
            <div class="pull-left">
                <h3>Silver Bullet</h3>
            </div>
            <div class="pull-right">
                <a href="{{ url('/project') }}">进入项目中心</a>
            </div>
        </div>
    </header>
    <div class="content">
        <div class="container">
            <h1>银弹 - 属于你的协作平台</h1>
            <h3>专为小型开发团队设计</h3>
            <el-button type="primary" style="width: 200px;font-size: 25px" plain @click="start">立即开始</el-button>
        </div>
    </div>
    <footer>

        Copyright&copy;2017 Designed by HyperQing
    </footer>
</div>
</body>
<script>
    let vue = new Vue({
        el: "#app",
        methods: {
            start: function () {
                window.location.href = "{{ url('/project') }}";
            }
        }
    })
</script>
</html>
