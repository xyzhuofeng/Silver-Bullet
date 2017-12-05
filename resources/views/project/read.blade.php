<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>项目中心 - 团队协作平台</title>
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ asset('js/element-ui/2.0.5/theme-chalk/index.css') }}">
    <link rel="stylesheet" href="{{ asset('js/public.css') }}">
    <script src="{{ asset('js/vue.js') }}"></script>
    <script src="{{ asset('js/element-ui/2.0.5/index.js') }}"></script>
    <script src="{{ asset('js/axios/0.17.1/axios.min.js') }}"></script>
    <title>项目中心 - 团队协作平台</title>
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
            min-height: 100vh;
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
            width: 40px;
            border: 0;
            border-radius: 50px;
            -moz-box-shadow: 0 0 6px #666;
            -webkit-box-shadow: 0 0 6px #666;
            box-shadow: 0 0 6px #666;
        }

        /*页面主体样式*/
        main {
            flex: 1;
        }

        main .left, main .right {
            margin: 20px;
            box-sizing: border-box;
            border: 1px solid #ccc;
        }

        section {
            padding: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background: #fff;
            box-sizing: border-box;
        }

        section + section {
            margin-top: 20px;
        }

        section .title {
            font-size: 18px;
        }

        /*页脚样式*/
        footer {
            margin: 20px 0;
            text-align: center;
            color: #888;
        }
    </style>
</head>
<body>
<div id="app" v-cloak>
    <div class="page">
        <el-menu default-active="1" class="el-menu-demo" mode="horizontal" @select="handleSelect">
            <el-row>
                <el-col :span="8">
                    <el-menu-item index="0">
                        <a href="{{url('/')}}" class="el-button el-button--text">
                            <span class="silver">Silver Bullet</span>
                        </a>
                    </el-menu-item>
                    <el-menu-item index="1">项目中心</el-menu-item>
                    <el-submenu index="2">
                        <template slot="title">我的工作台</template>
                        <el-menu-item index="2-1">选项1</el-menu-item>
                        <el-menu-item index="2-2">选项2</el-menu-item>
                        <el-menu-item index="2-3">选项3</el-menu-item>
                    </el-submenu>
                </el-col>
                <el-col :span="8">
                    <div class="page-title">
                        <span>从心约App</span>
                    </div>
                </el-col>
                <el-col :span="8">
                    <div class="page-right-corner">
                        <el-submenu index="3">
                            <template slot="title">您好，{{ session('user_name') }}</template>
                            <el-menu-item index="3-1">个人中心</el-menu-item>
                            <el-menu-item index="3-1">账号设置</el-menu-item>
                            <el-menu-item index="louout"><a href=""></a>退出</el-menu-item>
                        </el-submenu>
                        <el-menu-item index="4" class="avatar">
                            <img src="{{ session('user_avatar') }}" alt="用户头像">
                        </el-menu-item>
                    </div>
                </el-col>
            </el-row>
        </el-menu>
        <main>
            <el-row>
                <el-col :span="16">
                    <div class="left">
                        <section class="my-task">
                            <div class="title">我的任务</div>
                            XXX功能修改 <br>
                            修复XXXx逻辑错误<br>
                            优化页面样式<br>
                        </section>
                        <section class="my-task">
                            <div class="title">项目进度</div>
                            <el-row>
                                <el-col :span="8">
                                    8 个紧急任务待处理
                                </el-col>
                                <el-col :span="8">
                                    4个 功能正在开发
                                </el-col>
                                <el-col :span="8">
                                    2个 需求待开发
                                </el-col>
                            </el-row>
                            <el-row>
                                <el-col :span="8">
                                    1个线上版本正在运行
                                </el-col>
                                <el-col :span="8">
                                    1个测试进行中
                                </el-col>
                                <el-col :span="8">
                                    5个 Bug待修复
                                </el-col>
                            </el-row>
                        </section>
                        <section class="project-news">
                            <div class="title">项目动态</div>
                            <div>
                                用户A 更新了代码<br>
                                用户B 上传了文件 xxxx.doc<br>
                                用户C 添加了新任务<br>
                            </div>
                        </section>
                    </div>

                </el-col>
                <el-col :span="8">
                    <div class="right">
                        <section class="docker-history">
                            <div class="title">Docker容器版本</div>
                            <div>
                                <div>
                                    服务器 i1289a2f8b9: 已部署镜像 2f269a
                                </div>
                            </div>
                        </section>
                        <section class="commit-history">
                            <div class="title">Git 提交记录</div>
                            <div>
                                <div>
                                    <h3>GitHub hyperqing/congxinyue</h3>
                                    469379004@qq.com: 2017-12-05 11:09 提交了 2f269a <br>
                                    comment message：添加页面内容 <br>
                                    469379004@qq.com: 2017-12-05 11:09 提交了 2f269a <br>
                                    comment message：添加页面内容 <br>
                                    469379004@qq.com: 2017-12-05 11:09 提交了 2f269a <br>
                                    comment message：添加页面内容 <br>
                                    <h3>码云 hyperqing/congxinyue</h3>
                                    469379004@qq.com: 2017-12-05 11:09 提交了 2f269a <br>
                                    comment message：添加页面内容 <br>
                                    469379004@qq.com: 2017-12-05 11:09 提交了 2f269a <br>
                                    comment message：添加页面内容 <br>
                                    469379004@qq.com: 2017-12-05 11:09 提交了 2f269a <br>
                                    comment message：添加页面内容 <br>
                                </div>
                            </div>
                        </section>
                    </div>
                </el-col>
            </el-row>
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
            return {
                projLoading: false,
                projList: [],
                createProj: {
                    btn: "创建",
                    isLoading:
                      false, // 等待图标
                    dlgVisible:
                      false, // 显示创建项目对话框
                    form:
                      {  // 创建项目表单
                          project_name: "",
                          project_comment: ""
                      }
                },
            }
        },
        methods: {
            // 打开指定项目详情页面
            openProjPage: function (url) {
                window.location.href = url
            },
            // 导航条选择相应方法
            handleSelect: function (key, keyPath) {
                switch (key) {
                    case 'louout':
                        window.location.href = "{{ url('passport/logout') }}"
                }
            },
            // 创建项目ajax
            createProject: function () {
                let that = this;
                that.createProj.btn = "正在创建...";
                that.createProj.isLoading = true;
                axios.post("{{ url('project') }}", that.createProj.form)
                  .then(function (response) {
                      that.createProj.isLoading = false;
                      that.createProj.btn = "创建";
                      if (response.data.status !== 1) {
                          that.$message.error(response.data.info);
                      } else {
                          // 成功的情况，弹窗消失，表单清理
                          that.$message({
                              message: response.data.info,
                              type: "success",
                              center: true
                          });
                          that.createProj.dlgVisible = false;
                          that.createProj.form.project_name = "";
                          that.createProj.form.project_comment = "";
                          // 刷新项目列表
                          that.loadProjectList()
                      }
                  })
                  .catch(function (error) {
                      that.isLoading = false;
                      that.createProj.btn = "创建";
                      console.log(error);
                  });
            },
            // 加载项目列表
            loadProjectList: function () {
                // 开始加载
                this.projLoading = true;
                let that = this;
                axios.get("{{ url('project') }}")
                  .then(function (response) {
                      that.projLoading = false;
                      if (response.data.status !== 1) {
                          that.$message.error(response.data.info);
                      } else {
                          that.projList = response.data.data
                      }
                  })
                  .catch(function (error) {
                      that.isLoading = false;
                      that.createProj.btn = "创建";
                      console.log(error);
                  });
            }
        },
        // vue生命周期
        mounted: function () {
            // 加载项目列表
            this.loadProjectList()
        }
    })
</script>
</html>
