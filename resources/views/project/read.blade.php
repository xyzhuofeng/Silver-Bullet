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
    <title>从心约App - 看板 - 团队协作平台</title>
    <style>
        html, body {
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

        /*header菜单样式*/
        .el-menu .el-row {
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
            padding: 15px 20px 0;
        }

        /*页面主题各部分内容*/
        section {
            padding: 15px;
            border: 1px solid #ccc;
            border-radius: 6px;
            background: #fff;
            box-sizing: border-box;
        }

        /*section之间的间距*/
        section + section {
            margin-top: 20px;
        }

        section .title {
            display: flex;
            justify-content: space-between;

        }

        section .title span {
            display: block;
            font-size: 18px;
            padding: 12px 0;
        }

        /*任务条目*/
        .task {
            margin: 10px 0;
            padding: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
        }

        /*调整checkbox文字大小*/
        .task .el-checkbox__label {
            color: #2d2f33;
            font-size: 16px;
        }

        /*调整checkbox文字勾选后的状态*/
        .task .el-checkbox__input.is-checked + .el-checkbox__label {
            text-decoration: line-through;
            color: #878d99;
        }

        .task .deadline {
            margin-top: 8px;
            margin-left: 14px;
        }

        .task .deadline span {
            display: inline-block;
            padding: 4px 8px;
            border: 0;
            border-radius: 30px;
            font-size: 14px;
        }

        .task .deadline-normal span {
            background: #ecf5ff;
            color: #409eff;
        }

        .task .deadline-warning span {
            background: #fdf5e6;
            color: #eb9e05;
        }

        .task .deadline-danger span {
            background: #fee;
            color: #fa5555;
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
        <el-menu default-active="1" mode="horizontal" @select="handleSelect">
            <el-row>
                <el-col :span="9">
                    <el-menu-item index="0">
                        <a href="{{url('/')}}" class="el-button el-button--text">
                            <span class="silver">Silver Bullet</span>
                        </a>
                    </el-menu-item>
                    <el-menu-item index="1"><a class="el-button el-button--text" href="{{ url('project') }}">项目中心</a>
                    </el-menu-item>
                    <el-submenu index="2">
                        <template slot="title">我的工作台</template>
                        <el-menu-item index="2-1">选项1</el-menu-item>
                        <el-menu-item index="2-2">选项2</el-menu-item>
                        <el-menu-item index="2-3">选项3</el-menu-item>
                    </el-submenu>
                </el-col>
                <el-col :span="6">
                    <div class="page-title">
                        <span>从心约App</span>
                    </div>
                </el-col>
                <el-col :span="9">
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
        <el-menu default-active="看板" mode="horizontal" @select="handleSelect"
                 style="display: flex; justify-content: center">
            <el-menu-item index="看板">
                <a href="{{ url('project', $project_id) }}" class="el-button el-button--text">看板</a>
            </el-menu-item>
            <el-menu-item index="任务">
                <a href="{{url('/')}}" class="el-button el-button--text">任务</a>
            </el-menu-item>
            <el-menu-item index="需求">
                <a href="{{url('/')}}" class="el-button el-button--text">需求</a>
            </el-menu-item>
            <el-menu-item index="文件">
                <a href="{{url('/')}}" class="el-button el-button--text">文件</a>
            </el-menu-item>
            <el-menu-item index="审批">
                <a href="{{url('/')}}" class="el-button el-button--text">审批</a>
            </el-menu-item>
        </el-menu>
        <main>
            <el-row :gutter="20">
                <el-col :span="10">
                    <div class="left">
                        <section class="my-task">
                            <div class="title">
                                <span>我的任务</span>
                                <div>
                                    <a class="el-button el-button--text" @click="createTask.dlgVisible = true">
                                        <i class="el-icon-plus"></i> 创建任务
                                    </a>
                                </div>
                            </div>
                            <div class="task">
                                <el-checkbox>XXX功能修改</el-checkbox>
                                <el-tag size="small">实现功能</el-tag>
                                <div class="deadline deadline-danger">
                                    <span>明天 23：00 截止</span>
                                </div>
                            </div>
                            <div class="task">
                                <el-checkbox>修复XXXx逻辑错误</el-checkbox>
                                <el-tag size="small" type="danger">修复bug</el-tag>
                                <div class="deadline deadline-warning">
                                    <span>后天 18:00 截止</span>
                                </div>
                            </div>
                            <div class="task">
                                <el-checkbox>优化页面样式</el-checkbox>
                                <div class="deadline deadline-normal">
                                    <span>12月5日18:00 截止</span>
                                </div>
                            </div>
                        </section>
                        <section class="project-progress">
                            <div class="title"><span>项目进度</span></div>
                            <el-row>
                                <el-col :span="8">8 个紧急任务待处理</el-col>
                                <el-col :span="8">4个 功能正在开发</el-col>
                                <el-col :span="8">2个 需求待开发</el-col>
                            </el-row>
                            <el-row>
                                <el-col :span="8">1个线上版本正在运行</el-col>
                                <el-col :span="8">1个测试进行中</el-col>
                                <el-col :span="8">5个 Bug待修复</el-col>
                            </el-row>
                        </section>
                    </div>

                </el-col>
                <el-col :span="8">
                    <div class="center">
                        <section class="docker-history">
                            <div class="title">
                                <span>Docker容器版本</span>
                                <div>
                                    <a href="" class="el-button el-button--text"><i class="el-icon-refresh"></i> 刷新</a>
                                </div>
                            </div>
                            <div>
                                服务器 i1289a2f8b9: 已部署镜像 2f269a
                            </div>
                        </section>
                        <section class="commit-history">
                            <div class="title">
                                <span>代码提交记录</span>
                                <a href="" class="el-button el-button--text"><i class="el-icon-refresh"></i> 刷新</a>
                            </div>
                            <div>

                                <h3>GitHub hyperqing/congxinyue</h3>
                                469379004@qq.com: 2017-12-05 11:09 提交了 2f269a <br>
                                comment message：添加页面内容 <br>
                                469379004@qq.com: 2017-12-05 11:09 提交了 76cba2 <br>
                                comment message：添加页面内容 <br>
                                469379004@qq.com: 2017-12-05 11:09 提交了 968ade <br>
                                comment message：添加页面内容 <br>
                                <h3>码云 hyperqing/congxinyue</h3>
                                469379004@qq.com: 2017-12-05 11:09 提交了 2f269a <br>
                                comment message：添加页面内容 <br>
                                469379004@qq.com: 2017-12-05 11:09 提交了 76cba2 <br>
                                comment message：添加页面内容 <br>
                                469379004@qq.com: 2017-12-05 11:09 提交了 968ade <br>
                                comment message：添加页面内容 <br>
                            </div>
                        </section>
                    </div>
                </el-col>
                <el-col :span="6">
                    <div class="right">
                        <section class="project-news">
                            <div class="title"><span>项目动态</span></div>
                            <div>
                                用户A 更新了代码<br>
                                用户B 上传了文件 xxxx.doc<br>
                                用户C 添加了新任务<br>
                            </div>
                        </section>
                    </div>
                </el-col>
            </el-row>
        </main>
        <footer>
            Copyright &copy; 2017 Designed by HyperQing
        </footer>
    </div>
    <el-dialog title="创建任务" :visible.sync="createTask.dlgVisible" width="400px">
        <el-form label-width="80px">
            <el-form-item label="任务内容">
                <el-input v-model="createTask.form.task_content"></el-input>
            </el-form-item>
            <el-form-item label="截止时间">
                <el-date-picker type="datetime" placeholder="选择日期时间" align="center" v-model="createTask.form.deadline"
                                :picker-options="pickerOptions" value-format="yyyy-MM-dd HH:mm:ss">
                </el-date-picker>
            </el-form-item>
        </el-form>
        <span slot="footer" class="dialog-footer">
            <el-button @click="createTask.dlgVisible = false">取 消</el-button>
            <el-button type="primary" @click="createTaskFunc">@{{createTask.btn}}</el-button>
        </span>
    </el-dialog>
</div>
</body>
<script>
    let app = new Vue({
        el: '#app',
        data() {
            return {
                // 创建任务
                createTask: {
                    btn: "创建",
                    isLoading: false, // 等待图标
                    dlgVisible: false, // 显示创建对话框
                    form: {  // 创建项目表单
                        task_content: "",
                        deadline: "",
                        project_id: "{{ $project_id }}"
                    }
                },
                // 时间选择器快捷菜单
                pickerOptions: {
                    shortcuts: [{
                        text: '今天下班前',
                        onClick(picker) {
                            picker.$emit('pick', new Date());
                        }
                    }, {
                        text: '明天下班前',
                        onClick(picker) {
                            const date = new Date();
                            date.setTime(date.getTime() - 3600 * 1000 * 24);
                            picker.$emit('pick', date);
                        }
                    }, {
                        text: '后天下班前',
                        onClick(picker) {
                            const date = new Date();
                            date.setTime(date.getTime() - 3600 * 1000 * 24 * 7);
                            picker.$emit('pick', date);
                        }
                    }]
                }
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
            // 创建任务
            createTaskFunc: function () {
                let that = this;
                that.createTask.btn = "正在创建...";
                that.createTask.isLoading = true;
                axios.post("{{ url('task') }}", that.createTask.form)
                  .then(function (response) {
                      that.createTask.isLoading = false;
                      that.createTask.btn = "创建";
                      if (response.data.status !== 1) {
                          that.$message.error(response.data.info);
                      } else {
                          // 成功的情况，弹窗消失，表单清理
                          that.$message({
                              message: response.data.info,
                              type: "success",
                              center: true
                          });
                          that.createTask.dlgVisible = false;
                      }
                  })
                  .catch(function (error) {
                      that.createTask.isLoading = false;
                      that.createTask.btn = "创建";
                      console.log(error);
                  });
            },
            // 读取我的任务
            loadMyTask() {
                let that = this;
                axios.get("{{ route('mytask', ['protect_id'=>$project_id]) }}")
                  .then(function (response) {
                      if (response.data.status !== 1) {
                          that.$message.error(response.data.info);
                      } else {
                          // 成功的情况，弹窗消失，表单清理
                          that.$message({
                              message: response.data.info,
                              type: "success",
                              center: true
                          });
                      }
                  })
                  .catch(function (error) {
                      console.log(error);
                  });
            }
        },
        // vue生命周期
        mounted: function () {
            this.loadMyTask();
        }
    })
</script>
</html>
