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
            -moz-box-shadow: 0px 0px 6px #666666;
            -webkit-box-shadow: 0px 0px 6px #666666;
            box-shadow: 0px 0px 6px #666666;
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
            border-radius: 10px;
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

        .create-project {
            border: 1px dashed #888;
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
                        <span>项目中心</span>
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
                            <img src="{{ session('user_avatar') }}" alt="">
                        </el-menu-item>

                    </div>
                </el-col>
            </el-row>
        </el-menu>
        <main>
            <div class="project" v-loading="projLoading">
                <div class="row">
                    <div class="project-box create-project" @click="openCreateProjectjDialog">
                        <img src="{{asset('images/加号1.png')}}" alt="添加项目">
                        <span>创建您的项目</span>
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
    <el-dialog title="创建项目" :visible.sync="createProj.dlgVisible" width="580px">
        <el-form label-width="80px">
            <el-form-item label="项目名称">
                <el-input placeholder="例如: XX网站" v-model="createProj.form.project_name"></el-input>
            </el-form-item>
            <el-form-item label="项目备注">
                <el-input type="textarea" v-model="createProj.form.project_comment"></el-input>
            </el-form-item>
        </el-form>
        <span slot="footer">
            <el-button @click="createProj.dlgVisible = false">取消</el-button>
            <el-button type="primary" @click="createProject">@{{createProj.btn}}</el-button>
        </span>
    </el-dialog>
</div>
</body>
<script>
    new Vue({
        el: '#app',
        data() {
            return {
                projLoading: true,
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
                          project_comment:
                            ""
                      }
                },
            }
        },
        methods: {
            openCreateProjectjDialog: function () {
                this.createProj.dlgVisible = true;
            },
            handleSelect: function (key, keyPath) {
                switch (key) {
                    case 'louout':
                        window.location.href = "{{ url('passport/logout') }}"
                }
            },
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
                          that.createProj.form.project_name = ""
                          that.createProj.form.project_comment = ""
                      }
                  })
                  .catch(function (error) {
                      that.isLoading = false;
                      that.createProj.btn = "创建";
                      console.log(error);
                  });
            },
            loadProjectList: function () {
                // 开始加载
                this.projLoading = true;
                let that = this;
                axios.get("{{ url('project') }}", that.createProj.form)
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
        mounted: function () {

        }
    })
</script>
</html>
