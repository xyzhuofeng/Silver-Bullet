<template>
    <div class="container">
        <div class="title">
            <span>项目任务</span>
            <div>
                <a class="el-button el-button--text" @click="createTask.dlgVisible = true">
                    <i class="el-icon-plus"></i> 创建任务
                </a>
            </div>
        </div>
        <div v-loading="taskListLoading">
            <template v-if="myTaskList.length===0">
                <div class="empty-tips">
                    没有任务啦！
                </div>
            </template>
            <template v-for="item in myTaskList">
                <div class="task">
                    <el-row type="flex" class="row-bg" justify="space-between">
                        <el-col :span="6">
                            <el-checkbox v-model="item.is_finished" @change="finishTask(item.task_id)">
                                {{item.task_content}}
                            </el-checkbox>
                        </el-col>
                        <el-col :span="6" :offset="6" class="text-right">
                            <el-button type="danger" icon="el-icon-delete" @click="deleteTask(item.task_id)"
                                       class="btn-delete" circle></el-button>
                        </el-col>
                    </el-row>
                    <template v-for="tag in item.tag">
                        <el-tag size="small">{{tag}}</el-tag>
                    </template>
                    <div class="deadline deadline-normal" v-if="item.deadline">
                        <span>{{item.deadline}} 截止</span>
                    </div>
                    <p v-if="item.remark">备注： {{item.remark}}</p>
                    <p class="people">创建者：{{item.user_name}} 参与者：
                        <template v-for="user in item.task_user">
                            {{user.user_name}}&nbsp;
                        </template>
                    </p>
                </div>
            </template>
        </div>
        <!--<div class="task">-->
        <!--<el-checkbox>XXX功能修改</el-checkbox>-->
        <!--<el-tag size="small">实现功能</el-tag>-->
        <!--<div class="deadline deadline-danger">-->
        <!--<span>明天 23：00 截止</span>-->
        <!--</div>-->
        <!--</div>-->
        <!--<div class="task">-->
        <!--<el-checkbox>修复XXXx逻辑错误</el-checkbox>-->
        <!--<el-tag size="small" type="danger">修复bug</el-tag>-->
        <!--<div class="deadline deadline-warning">-->
        <!--<span>后天 18:00 截止</span>-->
        <!--</div>-->
        <!--</div>-->
        <!--<div class="task">-->
        <!--<el-checkbox>优化页面样式</el-checkbox>-->
        <!--<div class="deadline deadline-normal">-->
        <!--<span>12月5日18:00 截止</span>-->
        <!--</div>-->
        <!--</div>-->
        <el-dialog title="创建任务" :visible.sync="createTask.dlgVisible" width="600px">
            <el-form label-width="80px">
                <el-form-item label="任务内容">
                    <el-input v-model="createTask.form.task_content"></el-input>
                </el-form-item>
                <el-form-item label="备注">
                    <el-input type="textarea" v-model="createTask.form.remark"></el-input>
                </el-form-item>
                <el-form-item label="截止时间">
                    <el-date-picker type="datetime" placeholder="选择日期时间" align="center"
                                    v-model="createTask.form.deadline"
                                    :picker-options="pickerOptions" value-format="yyyy-MM-dd HH:mm:ss">
                    </el-date-picker>
                </el-form-item>
                <el-form-item label="任务标签">
                    <el-select v-model="createTask.form.tag_list" multiple filterable allow-create default-first-option
                               placeholder="请输入任务标签">
                        <el-option v-for="item in createTask.tagOptions" :key="item.value" :label="item.label"
                                   :value="item.value"></el-option>
                    </el-select>
                </el-form-item>
                <el-form-item label="参与者">
                    <el-select v-model="createTask.form.task_user" multiple placeholder="请选择参与者">
                        <el-option v-for="item in createTask.memberOption" :key="item.user_id" :label="item.user_name"
                                   :value="item.user_id">
                        </el-option>
                    </el-select>
                </el-form-item>
            </el-form>
            <span slot="footer" class="dialog-footer">
            <el-button @click="createTask.dlgVisible = false">取 消</el-button>
            <el-button type="primary" @click="createTaskFunc">{{createTask.btn}}</el-button>
        </span>
        </el-dialog>
    </div>
</template>

<script>
    export default {
        name: "task-item",
        data() {
            let that = this;
            return {
                // 任务窗口加载动画
                taskListLoading: true,
                // 创建任务
                createTask: {
                    btn: "创建",
                    isLoading: false, // 等待图标
                    dlgVisible: false, // 显示创建对话框
                    form: {  // 创建项目表单
                        task_content: "", // 任务内容
                        remark: "", // 备注
                        deadline: "", // 截止时间
                        project_id: that.taskItemData.project_id,
                        tag_list: [], // 标签列表
                        task_user: [], // 参与者用户列表
                    },
                    memberOption: [], // 备选的参与者列表
                    tagOptions: [ // 任务标签列表
                        {value: "功能", label: "功能",},
                        {value: "Bug", label: "Bug",},
                        {value: "变更需求", label: "变更需求",},
                        {value: "新增需求", label: "新增需求",},
                    ],
                },
                // 我的任务列表
                myTaskList: [],
                // 时间选择器快捷菜单
                pickerOptions: {
                    shortcuts: [{
                        text: '今天下班前',
                        onClick(picker) {
                            const date = new Date();
                            date.setHours(18);
                            date.setMinutes(0);
                            date.setSeconds(0);
                            picker.$emit('pick', date);
                        }
                    }, {
                        text: '明天下班前',
                        onClick(picker) {
                            const date = new Date();
                            date.setDate(date.getDate() + 1);
                            date.setHours(18);
                            date.setMinutes(0);
                            date.setSeconds(0);
                            picker.$emit('pick', date);
                        }
                    }, {
                        text: '后天下班前',
                        onClick(picker) {
                            const date = new Date();
                            date.setDate(date.getDate() + 2);
                            date.setHours(18);
                            date.setMinutes(0);
                            date.setSeconds(0);
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
                        window.location.href = that.taskItemData.project_id
                }
            },
            // 获取成员列表
            getMemberList() {
                let that = this;
                axios.get(that.taskItemData.getMemberListUrl)
                  .then(function (response) {
                      if (response.data.status === 1) {
                          that.createTask.memberOption = response.data.data.project_user_list
                      } else {
                          that.$message.error(response.data.info);
                      }
                  })
                  .catch(function (error) {
                      console.log(error);
                  });
            },
            // 创建任务
            createTaskFunc: function () {
                let that = this;
                that.createTask.btn = "正在创建...";
                that.createTask.isLoading = true;
                axios.post(that.taskItemData.createTaskUrl, that.createTask.form)
                  .then(function (response) {
                      that.loadMyTask();
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
                          // that.loadMyTask();
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
                that.taskListLoading = true;
                let url = this.taskItemData.myTaskUrl;
                if (that.taskItemData.task_type === 'all') {
                    url = this.taskItemData.myTaskUrl;
                }
                if (that.taskItemData.task_type === 'unfinish') {
                    url = this.taskItemData.unfinishTaskUrl;
                }
                axios.get(url)
                  .then(function (response) {
                      that.taskListLoading = false;
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
                let that = this;
                axios.post(this.taskItemData.finishTaskUrl, {
                    task_id: task_id
                })
                  .then(function (response) {
                      if (response.data.status === 1) {
                          that.$message.success(response.data.info);
                      } else {
                          that.$message.error(response.data.info);
                      }
                  })
                  .catch(function (error) {
                      console.log(error);
                  });
            },
            // 删除任务
            deleteTask(task_id) {
                let that = this;
                this.$confirm('此操作将永久删除该任务, 是否继续?', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning'
                }).then(() => {
                    axios.post(this.taskItemData.deleteTaskUrl, {
                        task_id: task_id
                    })
                      .then(function (response) {
                          that.loadMyTask();
                          if (response.data.status === 1) {
                              that.$message.success(response.data.info);
                          } else {
                              that.$message.error(response.data.info);
                          }
                      })
                      .catch(function (error) {
                          console.log(error);
                      });
                }).catch(() => {
                });
            },
        },
        mounted() {
            this.loadMyTask();
            this.getMemberList();
        }
    }
</script>
<style>
    /*调整checkbox文字大小*/
    .task .el-checkbox__label {
        color: #222;
    }

    /*调整checkbox文字勾选后的状态*/
    .task .el-checkbox__input.is-checked + .el-checkbox__label {
        text-decoration: line-through;
        color: #878d99;
    }
</style>
<style scoped>
    .empty-tips {
        margin: 10px 0;
        text-align: center;
        color: #888;
    }

    /*留空间距*/
    .el-tag {
        margin-right: 5px;
    }

    .container {
        width: 100%;
        max-width: 800px;
        margin: 0 auto;
    }

    /*任务条目*/
    .task {
        margin: 10px 0;
        padding: 10px;
        box-sizing: border-box;
        border: 1px solid #ccc;
        border-radius: 6px;
    }

    /*删除按钮默认隐藏*/
    .task .btn-delete {
        visibility: hidden;
        font-size: 14px;
        border-radius: 100px;
        padding: 10px 10px;
    }

    /*鼠标经过任务时显示*/
    .task:hover .btn-delete {
        visibility: visible;
    }

    /*调整checkbox文字勾选后的状态*/
    .task .el-checkbox__input.is-checked + .el-checkbox__label {
        text-decoration: line-through;
        color: #878d99;
    }

    .task .deadline {
        margin-top: 8px;
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

    .task p {
        margin: 5px 0;
        color: #777;
        font-size: 14px;
    }
</style>