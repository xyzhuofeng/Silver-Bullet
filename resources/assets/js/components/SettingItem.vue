<template>
    <div class="container clearfix">
        <el-row :gutter="20">
            <el-col :span="6">
                <el-menu default-active="项目设置" @select="handleSelect">
                    <el-menu-item index="项目设置">
                        <i class="el-icon-menu"></i>
                        <span slot="title">项目设置</span>
                    </el-menu-item>
                    <el-menu-item index="成员管理" disabled>
                        <i class="el-icon-service"></i>
                        <span slot="title">成员管理</span>
                    </el-menu-item>
                    <el-menu-item index="高级设置">
                        <i class="el-icon-setting"></i>
                        <span slot="title">高级设置</span>
                    </el-menu-item>
                    <el-menu-item index="Git绑定">
                        <i class="el-icon-share"></i>
                        <span slot="title">Git绑定</span>
                    </el-menu-item>
                </el-menu>
            </el-col>
            <el-col :span="18">
                <el-form label-position="top" label-width="80px" :model="form">
                    <el-form-item label="项目名称">
                        <el-input v-model="settingItemData.project_name" @blur="updateProjName"></el-input>
                    </el-form-item>
                    <el-form-item label="项目描述">
                        <el-input type="textarea" v-model="settingItemData.project_comment"
                                  @blur="updateProjComment"></el-input>
                    </el-form-item>
                    <el-form-item label="封面图">
                        <img :src="settingItemData.project_thumb" alt="用户头像" class="thumb">
                        <div>
                            <el-button type="text" native-type="button" @click="updateThumbData.isVisible=true">
                                上传图片
                            </el-button>
                        </div>
                    </el-form-item>
                </el-form>
            </el-col>
        </el-row>
        <el-dialog title="上传封面图" :visible.sync="updateThumbData.isVisible" width="30%">
            <span>请选择封面图</span>
            <el-upload class="thumb-uploader"
                       :action="settingItemData.updateThumbUrl"
                       :show-file-list="false" name="thumb"
                       :on-success="handleThumbSuccess">
                <img v-if="updateThumbData.imageUrl" :src="updateThumbData.imageUrl" class="thumb">
                <i v-else class="el-icon-plus thumb-uploader-icon"></i>
            </el-upload>
            <span slot="footer" class="dialog-footer">
                <el-button @click="updateThumbData.isVisible = false">取 消</el-button>
                <el-button type="primary" @click="updateThumbData.isVisible = false">完 成</el-button>
              </span>
        </el-dialog>
    </div>
</template>

<script>
    export default {
        name: "setting-item",
        data() {
            return {
                form: {},
                updateThumbData: {
                    isVisible: false,
                    imageUrl: "",
                },
            }
        },
        methods: {
            // 导航条选择相应方法
            handleSelect: function (key, keyPath) {
                switch (key) {
                    case 'louout':
                        window.location.href = this.headerData.logoutUrl;
                        break;
                    case '个人中心':
                        window.location.href = this.headerData.usercenterUrl;
                        break;
                }
            },
            // 成功上传图片
            handleThumbSuccess(res, file) {
                this.updateThumbData.imageUrl = URL.createObjectURL(file.raw);
                this.settingItemData.project_thumb = URL.createObjectURL(file.raw);
            },
            // 更新项目名称
            updateProjName: function () {
                let that = this;
                axios.post(that.profileData.updatePasswordUrl, {
                    original_password: that.updatePasswordData.original_password,
                    new_password: that.updatePasswordData.new_password,
                    confirm_password: that.updatePasswordData.confirm_password,
                })
                  .then(function (response) {
                      if (response.data.status !== 1) {
                          that.$message.error(response.data.info);
                      } else {
                          that.$message({message: response.data.info, type: "success"});
                          // 清理输入
                          that.updatePasswordData.confirm_password = "";
                          that.updatePasswordData.original_password = "";
                          that.updatePasswordData.new_password = "";
                          // 关闭弹窗
                          that.updatePasswordData.isVisible = false;
                      }
                  })
                  .catch(function (error) {
                      console.log(error);
                  });
            },
            // 更新职位
            updateProjComment: function () {
                let that = this;
                axios.post(that.profileData.updateJobUrl, {
                    job: that.form.job
                })
                  .then(function (response) {
                      if (response.data.status !== 1) {
                          that.$message.error(response.data.info);
                      } else {
                          that.$message({message: response.data.info, type: "success"});
                      }
                  })
                  .catch(function (error) {
                      console.log(error);
                  });
            },
            // 更新姓名
            updateName: function () {
                let that = this;
                axios.post(that.profileData.updateNameUrl, {
                    user_name: that.form.user_name
                })
                  .then(function (response) {
                      if (response.data.status !== 1) {
                          that.$message.error(response.data.info);
                      } else {
                          that.$message({message: response.data.info, type: "success"});
                      }
                  })
                  .catch(function (error) {
                      console.log(error);
                  });
            }
        },
    }
</script>

<style scoped>
    .clearfix:after {
        display: block;
        content: ' ';
        clear: both;
    }

    .container {
        width: 800px;
        margin: 0 auto;
    }

    .thumb {
        width: 150px;
        height: 150px;
    }
</style>

<style>
    .thumb-uploader .el-upload {
        border: 1px dashed #d9d9d9;
        border-radius: 6px;
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }

    .thumb-uploader .el-upload:hover {
        border-color: #409EFF;
    }

    .thumb-uploader-icon {
        font-size: 28px;
        color: #8c939d;
        width: 178px;
        height: 178px;
        line-height: 178px;
        text-align: center;
    }
</style>