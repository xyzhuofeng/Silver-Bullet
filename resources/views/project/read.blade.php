<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ url(mix('css/app.css')) }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>看板 - {{ \App\Http\Middleware\ViewTempleteVal::$projectName }} - 团队协作平台</title>
    <style>
        html, body {
            background: #e7eaf1;
            font-family: "Helvetica Neue", Helvetica, "PingFang SC", "Hiragino Sans GB", "Microsoft YaHei", "微软雅黑", Arial, sans-serif;
        }

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

        /*git动态信息*/
        .commit-history p {
            margin: 5px 0;
            color: #555;
            font-size: 14px;
        }

        .commit-history p code {
            background: #e7eaf1;
            color: #888;
            padding: 0 5px;
            font-family: Consolas, sans-serif;
        }

        .commit-history h3 {
            color: #555;
            font: 16px Consolas, sans-serif;
        }

        .git-row {
            color: #888;
        }

        .git-row + .git-row {
            border-top: 1px solid #ccc;
            padding-top: 10px;
        }

        /*项目动态*/

        .sb-timeline p {
            margin: 5px 0 0;
            font-size: 14px;
            color: #777;
        }

        .sb-timeline p:first-of-type {
            font-size: 15px;
            color: #222;
        }

        .sb-timeline + .sb-timeline {
            margin-top: 10px;
            border-top: 1px #ccc solid;
        }

        .sb-timeline-text {
            margin: 0 5px;
            padding: 0 5px;
            background: #e7eaf1;
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
            <el-row :gutter="20">
                <el-col :span="8">
                    <div class="left">
                        <section class="my-task">
                            <task-item :task-item-data="taskItemData"></task-item>
                        </section>
                    </div>
                </el-col>
                <el-col :span="8">
                    <div class="center">
                        <section class="commit-history" v-loading="gitdata.loading">
                            <div class="title">
                                <span>代码提交记录</span>
                                <el-button type="primary" size="mini" @click="git" plain><i class="el-icon-refresh"></i>
                                    刷新
                                </el-button>
                            </div>
                            <div>
                                <h3 v-if="gitdata.data">项目: @{{ gitdata.data[0].repo.name }}</h3>
                                <template v-for="item in gitdata.data">
                                    <template v-if="item.type ==='PushEvent'">
                                        <div class="git-row">
                                            <el-row>
                                                <el-col :span="3">
                                                    <img :src="item.actor.avatar_url" width="32px"
                                                         style="border-radius: 50px">
                                                </el-col>
                                                <el-col :span="6">
                                                    @{{item.actor.display_login}}
                                                </el-col>
                                                <el-col :span="15">
                                                    @{{item.created_at}}
                                                </el-col>
                                            </el-row>
                                            <template v-for="commit in item.payload.commits">
                                                <p><code>@{{commit.sha.substr(0,8)}}</code> @{{commit.message}}</p>
                                            </template>
                                        </div>
                                    </template>
                                    <template v-if="item.type ==='CreateEvent'">
                                        <div class="git-row">
                                            <el-row>
                                                <el-col :span="3">
                                                    <img :src="item.actor.avatar_url" width="28px"
                                                         style="border-radius: 50px">
                                                </el-col>
                                                <el-col :span="6">
                                                    @{{item.actor.display_login}}
                                                </el-col>
                                                <el-col :span="15">
                                                    @{{item.created_at}}
                                                </el-col>
                                            </el-row>
                                            <p>发布 @{{item.payload.ref_type}}：<code>@{{item.payload.ref}}</code></p>
                                        </div>
                                    </template>
                                </template>
                            </div>
                        </section>
                    </div>
                </el-col>
                <el-col :span="8">
                    <div class="right">
                        <section class="project-news">
                            <div class="title"><span>项目动态</span></div>
                            <template v-for="line in timeline.data">
                                <div class="sb-timeline">
                                    <p>@{{line.user_name}}</p>
                                    <p v-html="line.content"></p>
                                    <p>@{{line.created_at}}</p>
                                </div>
                            </template>
                        </section>
                    </div>
                </el-col>
            </el-row>
        </main>
        <footer-component></footer-component>
    </div>
</div>
</body>
<script src="{{ url(mix('js/app.js')) }}"></script>
@include('public.vue_value')
<script>
    let myapp = new Vue({
        el: '#app',
        data() {
            return {
                // 传给子组件数据
                // 导航条数据
                headerData: headerData,
                // 二级导航数据
                secondNavData: secondNavData,
                // 任务组件数据
                taskItemData: taskItemData,
                // 项目动态数据
                timeline: {
                    loading: false,
                    data: [],
                },
                // git动态数据
                gitdata: {
                    loading: false,
                    url: "{{$project->githuburl}}",
                    data: null, // github数据
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
            git() {
                let that = this;
                if (this.gitdata.url === '') {
                    return;
                }
                that.gitdata.loading = true;
                axios.get("{{ route('project/git', \App\Http\Middleware\ViewTempleteVal::$projectId) }}")
                  .then(function (response) {
                      that.gitdata.loading = false;
                      if (response.data.status === 1) {
                          that.gitdata.data = response.data.data.git;
                      } else {
                          that.$message.error(response.data.info);
                      }
                  })
                  .catch(function (error) {
                      console.log(error);
                  });
            },
            getTimeline() {
                let that = this;
                that.timeline.loading = true;
                axios.get("{{ route('project/timeline', \App\Http\Middleware\ViewTempleteVal::$projectId) }}")
                  .then(function (response) {
                      that.timeline.loading = false;
                      if (response.data.status === 1) {
                          that.timeline.data = response.data.data;
                      } else {
                          that.$message.error(response.data.info);
                      }
                  })
                  .catch(function (error) {
                      console.log(error);
                  });
            }
        },
        beforeMount() {
            this.taskItemData.task_type = "unfinish";
        },
        // vue生命周期
        mounted: function () {
            this.git();
            this.getTimeline();
            this.secondNavData.defaultActive = "看板";
        }
    })
</script>
</html>
