<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ url(mix('css/app.css')) }}">
    <title>项目中心 - 团队协作平台</title>
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

        .project {
            width: 1200px;
            min-height: 700px;
            margin: 15px auto 0;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 6px;
            background: #fff;
            overflow-y: auto;
        }

        .project-list {
            display: flex;
            flex-wrap: wrap;
            margin: 25px auto;
            width: 1080px;
            box-sizing: border-box;
        }

        .project-box {
            flex: 1 150px;
            max-width: 150px;
            height: 150px;
            margin: 15px;
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
        <header-nav :header-data="headerData"></header-nav>
        <main>
            <div class="project" v-loading="projLoading">
                <div class="project-list">
                    <div class="project-box create-project" @click="createProj.dlgVisible = true">
                        <img src="{{ asset('images/加号1.png') }}" alt="添加项目">
                        <span>创建您的项目</span>
                    </div>
                    <template v-for="item in projList">
                        <div class="project-box" :title="item.project_name" @click="openProjPage(item.project_url)">
                            <img :src="item.project_thumb" :alt="item.project_name">
                            <span>@{{ item.creator }}/@{{ item.project_name }}</span>
                        </div>
                    </template>
                </div>
            </div>
        </main>
        <footer-component></footer-component>
    </div>
    <el-dialog title="创建项目" :visible.sync="createProj.dlgVisible" width="580px">
        <el-form label-width="80px">
            <el-form-item label="项目名称">
                <el-input placeholder="例如: 我的博客" v-model="createProj.form.project_name"></el-input>
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
<script src="{{ url(mix('js/app.js')) }}"></script>
<script>
    let app = new Vue({
        el: '#app',
        data() {
            return {
                // 传给子组件数据
                // 导航条数据
                headerData: {
                    username: "{{ session('user_name') }}",
                    avatarUrl: "{{ session('user_avatar') }}",
                    logoutUrl: "{{ url('passport/logout') }}",
                    projectName: "",
                    usercenterUrl: "{{ url('user') }}",
                    projectUrl: "{{ url('project') }}",
                },
                projLoading: false,
                projList: [],
                createProj: {
                    btn: "创建",
                    isLoading: false, // 等待图标
                    dlgVisible: false, // 显示创建项目对话框
                    form: {  // 创建项目表单
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
                      that.createProj.isLoading = false;
                      that.createProj.btn = "创建";
                      console.log(error);
                  });
            },
            // 加载项目列表
            loadProjectList: function () {
                // 开始加载
                this.projLoading = true;
                let that = this;
                axios.get("{{ url('project/list') }}")
                  .then(function (response) {
                      that.projLoading = false;
                      if (response.data.status !== 1) {
                          that.$message.error(response.data.info);
                      } else {
                          that.projList = response.data.data
                      }
                  })
                  .catch(function (error) {
                      that.createProj.isLoading = false;
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
