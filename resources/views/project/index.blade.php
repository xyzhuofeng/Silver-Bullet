<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>项目中心 - 团队协作平台</title>
    <script src="https://cdn.bootcss.com/vue/2.5.8/vue.min.js"></script>
    <script src="https://cdn.bootcss.com/element-ui/2.0.5/index.js"></script>
    <link href="https://cdn.bootcss.com/element-ui/2.0.5/theme-chalk/index.css" rel="stylesheet">
    <script src="https://cdn.bootcss.com/axios/0.17.1/axios.min.js"></script>
    <title>Laravel</title>
    <style>
        [v-cloak] {
            display: none;
        }

        html, body {
            height: 100%;
            width: 100%;
            margin: 0;
            padding: 0;
            background: #e7eaf1;
            font-family: "Helvetica Neue", Helvetica, "PingFang SC", "Hiragino Sans GB", "Microsoft YaHei", "微软雅黑", Arial, sans-serif;

        }

        /*整页采用flex纵向布局，实现页脚自适应*/
        .page {
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        /*header样式*/
        .el-row {
            outline: none;
        }

        .page-title {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 60px;
        }

        .page-title span {
            display: block;
            font-size: 20px;
        }

        .page-right-corner {
            display: flex;
            justify-content: flex-end;
            height: 60px;
            padding-right: 20px;
        }

        .avatar {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .avatar img {
            display: block;
            width: 32px;
        }

        /*页面主体样式*/
        main {
            flex: 1;
        }

        .project {
            width: 1200px;
            min-height: 700px;
            margin: 15px auto 0;
            padding: 25px;
            box-sizing: border-box;
            border: 1px #ccc solid;
            border-radius: 10px;
            background: #fff;
            overflow-y: auto;
        }

        .row {
            display: flex;
            justify-content: space-around;
            margin-bottom: 20px;
        }

        .project-box {
            width: 150px;
            height: 150px;
            padding: 20px 0 0 0;
            box-sizing: border-box;
            text-align: center;
            cursor: pointer;
            border: 0;
            border-radius:10px;
            transition: transform .2s ease, background .2s ease;
        }

        .project-box:hover {
            transform: translateY(-5px);
            background: #e7eaf1;
        }

        .project-box img {
            width: 80px;
            height: 80px;
        }

        .project-box span {
            display: block;
            margin-top: 8px;
        }

        /*页脚样式*/
        footer {
            margin: 15px 0;
            text-align: center;
            color: #888;
        }
    </style>
</head>
<body>
<div id="app" v-cloak>
    <div class="page">
        <el-menu default-active="1" class="el-menu-demo" mode="horizontal" @select="">
            <el-row>
                <el-col span="8">
                    <el-menu-item index="1">处理中心</el-menu-item>
                    <el-submenu index="2">
                        <template slot="title">我的工作台</template>
                        <el-menu-item index="2-1">选项1</el-menu-item>
                        <el-menu-item index="2-2">选项2</el-menu-item>
                        <el-menu-item index="2-3">选项3</el-menu-item>
                    </el-submenu>
                </el-col>
                <el-col span="8">
                    <div class="page-title">
                        <span>项目中心</span>
                    </div>
                </el-col>
                <el-col span="8">
                    <div class="page-right-corner">
                        <el-submenu index="3">
                            <template slot="title">您好，HyperQing</template>
                            <el-menu-item index="3-1">个人中心</el-menu-item>
                            <el-menu-item index="3-2">退出</el-menu-item>
                        </el-submenu>
                        <el-menu-item index="4" class="avatar">
                            <img src="{{asset('images/物品申请.png')}}" alt="">
                        </el-menu-item>

                    </div>
                </el-col>
            </el-row>
        </el-menu>
        <main>
            <div class="project">
                <div class="row">
                    <div class="project-box">
                        <img src="{{asset('images/物品申请.png')}}" alt="项目图片">
                        <span>小喵小程序</span>
                    </div>
                    <div class="project-box">
                        <img src="{{asset('images/物品申请.png')}}" alt="项目图片">
                        <span>小喵小程序</span>
                    </div>
                    <div class="project-box">
                        <img src="{{asset('images/物品申请.png')}}" alt="项目图片">
                        <span>小喵小程序</span>
                    </div>
                    <div class="project-box">
                        <img src="{{asset('images/物品申请.png')}}" alt="项目图片">
                        <span>小喵小程序</span>
                    </div>
                    <div class="project-box">
                        <img src="{{asset('images/物品申请.png')}}" alt="项目图片">
                        <span>小喵小程序</span>
                    </div>
                </div>
                <div class="row">
                    <div class="project-box">
                        <img src="{{asset('images/物品申请.png')}}" alt="项目图片">
                        <span>小喵小程序</span>
                    </div>
                    <div class="project-box">
                        <img src="{{asset('images/物品申请.png')}}" alt="项目图片">
                        <span>小喵小程序</span>
                    </div>
                    <div class="project-box">
                        <img src="{{asset('images/物品申请.png')}}" alt="项目图片">
                        <span>小喵小程序</span>
                    </div>
                    <div class="project-box">
                        <img src="{{asset('images/物品申请.png')}}" alt="项目图片">
                        <span>小喵小程序</span>
                    </div>
                    <div class="project-box">
                        <img src="{{asset('images/物品申请.png')}}" alt="项目图片">
                        <span>小喵小程序</span>
                    </div>
                </div>
            </div>
        </main>
        <footer>
            Copyright&copy;2017 Designed by HyperQing
        </footer>
    </div>
</div>
</body>
<script>
    new Vue({
        el: '#app',
        data() {
            return {}
        },
        methods: {}
    })
</script>
</html>
