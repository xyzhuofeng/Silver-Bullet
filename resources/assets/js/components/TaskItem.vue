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
        <template v-for="item in myTaskList" v-loading="taskListLoading">
            <div class="task">
                <el-checkbox v-model="item.is_finished" @change="finishTask(item.task_id)">{{item.task_content}}
                </el-checkbox>
                <template v-for="tag in item.tag">
                    <el-tag size="small">{{tag}}</el-tag>
                </template>
                <div class="deadline deadline-normal">
                    <span>{{item.deadline}} 截止</span>
                </div>
                <p v-if="item.remark">备注： {{item.remark}}</p>
                <p class="people">创建者：{{item.user_name}} 参与者：{{item.user_name}}</p>
            </div>
        </template>
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
        <el-dialog title="创建任务" :visible.sync="createTask.dlgVisible" width="400px">
            <el-form label-width="80px">
                <el-form-item label="任务内容">
                    <el-input v-model="createTask.form.task_content"></el-input>
                </el-form-item>
                <el-form-item label="备注">
                    <el-input v-model="createTask.form.remark"></el-input>
                </el-form-item>
                <el-form-item label="截止时间">
                    <el-date-picker type="datetime" placeholder="选择日期时间" align="center"
                                    v-model="createTask.form.deadline"
                                    :picker-options="pickerOptions" value-format="yyyy-MM-dd HH:mm:ss">
                    </el-date-picker>
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
                taskListLoading: false,
                // 创建任务
                createTask: {
                    btn: "创建",
                    isLoading: false, // 等待图标
                    dlgVisible: false, // 显示创建对话框
                    form: {  // 创建项目表单
                        task_content: "",
                        remark: "",
                        deadline: "",
                        project_id: that.taskItemData.project_id
                    }
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
                axios.get(this.taskItemData.myTaskUrl)
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
            }
        },
        mounted() {
            this.loadMyTask();
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
    /*留空间距*/
    .el-tag {
        margin-right: 5px;
    }

    .container {
        width: 800px;
        margin: 0 auto;
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

    .task p{
        margin: 5px 0;
        color: #777;
        font-size: 14px;
    }
</style>