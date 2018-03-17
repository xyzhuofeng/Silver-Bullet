<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ url(mix('css/app.css')) }}">

    <link rel="stylesheet" href="{{ asset('js/fonts.googleapis.com.css') }}">
    <link rel="stylesheet" href="{{ asset('js/element-ui/2.0.5/theme-chalk/index.css') }}">
    <link rel="stylesheet" href="{{ asset('js/public.css') }}">
    <title>任务 - 从心约App - 团队协作平台</title>
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
            width: 800px;
            margin: 0 auto;
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
        <header-nav :header-data="headerData"></header-nav>
        <second-nav :second-nav-data="secondNavData"></second-nav>
        <main>
            <section>
                <div class="title">
                    <span>项目任务</span>
                    <div>
                        <a class="el-button el-button--text" @click="createTask.dlgVisible = true">
                            <i class="el-icon-plus"></i> 创建任务
                        </a>
                    </div>
                </div>
                <template v-for="item in myTaskList">
                    <div class="task">
                        <el-checkbox v-model="item.is_finished">@{{item.task_content}}</el-checkbox>
                        <el-tag size="small">实现功能</el-tag>
                        <div class="deadline deadline-danger">
                            <span>明天 23：00 截止</span>创建者：@{{item.user_name}}
                        </div>
                    </div>
                </template>
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
        </main>
        <footer-component></footer-component>
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
<script src="{{ url(mix('js/app.js')) }}"></script>
@include('public.vue_value')
<script>
    let app = new Vue({
        el: '#app',
        data() {
            return {
                // 传给子组件数据
                // 导航条数据
                headerData: headerData,
                // 二级导航数据
                secondNavData: secondNavData,
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
                // 我的任务列表
                myTaskList: [],
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
                          that.loadMyTask();
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
                axios.get("{{ route('task/my', ['protect_id'=>$project_id]) }}")
                  .then(function (response) {
                      if (response.data.status !== 1) {
                          that.$message.error(response.data.info);
                      } else {
                          that.myTaskList = response.data.data;
                      }
                  })
                  .catch(function (error) {
                      console.log(error);
                  });
            },
            // 完成任务
            finishTask(task_id) {
                alert();
                return;
                let that = this;
                axios.get("{{ route('task/my', ['protect_id'=>$project_id]) }}")
                  .then(function (response) {
                      if (response.data.status !== 1) {
                          that.$message.error(response.data.info);
                      } else {
                          that.myTaskList = response.data.data;
                      }
                  })
                  .catch(function (error) {
                      console.log(error);
                  });
            }
        },
        // vue生命周期
        mounted: function () {
            this.secondNavData.defaultActive = "任务";
            this.loadMyTask();
        }
    })
</script>
</html>
