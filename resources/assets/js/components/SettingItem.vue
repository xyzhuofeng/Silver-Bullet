<template>
    <div class="container clearfix">
        <el-row :gutter="20">
            <el-col :span="6">
                <el-menu :default-active="defaultActive" @select="handleSelect">
                    <el-menu-item index="项目设置">
                        <i class="el-icon-menu"></i>
                        <span slot="title">项目设置</span>
                    </el-menu-item>
                    <el-menu-item index="成员管理">
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
                <template v-if="defaultActive === '项目设置'">
                    <el-form label-position="top" label-width="80px" :model="form">
                        <el-form-item label="项目名称">
                            <el-input v-model="settingItemData.project_name" @blur="updateNameAndComment"></el-input>
                        </el-form-item>
                        <el-form-item label="项目描述">
                            <el-input type="textarea" v-model="settingItemData.project_comment"
                                      @blur="updateNameAndComment"></el-input>
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
                </template>
                <template v-if="defaultActive === '成员管理'">
                    <el-row>
                        <el-col :span="24">
                            <el-button size="mini" type="primary">邀请加入新成员</el-button>
                        </el-col>
                    </el-row>
                    <el-table :data="member.list" style="width: 100%" v-loading="member.loading">
                        <el-table-column prop="user_avatar" label="头像" width="64" align="center">
                            <template slot-scope="scope">
                                <img :src="scope.row.user_avatar" class="avatar-radius">
                            </template>
                        </el-table-column>
                        <el-table-column prop="user_name" label="姓名" align="center"></el-table-column>
                        <el-table-column prop="job" label="职位" align="center"></el-table-column>
                        <el-table-column prop="role" label="角色" align="center"></el-table-column>
                        <el-table-column label="操作" align="center">
                            <template slot-scope="scope">
                                <el-button type="text" v-if="scope.row.role === 'creator'">项目拥有者</el-button>
                                <el-button type="danger" size="mini" v-if="scope.row.role !== 'creator'"
                                           @click="removeMember(scope.$index, scope.row.user_id)">
                                    移出项目
                                </el-button>
                            </template>
                            <!--<template slot-scope="scope" v-if="scope.row.role !== 'creator'">-->
                                <!--{{scope.row.role}}-->

                                <el-button type="danger" size="mini"
                                           @click="removeMember(scope.$index, scope.row.user_id)">
                                    移出项目
                                </el-button>
                            <!--</template>-->
                        </el-table-column>

                    </el-table>
                </template>
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
                member: {
                    list: [], // 成员列表
                    loading: false, // 加载动画
                },
                defaultActive: "成员管理", // 默认菜单激活项
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
                this.defaultActive = key;
                switch (key) {
                    case "成员管理":
                        // 更新成员列表
                        this.getMemberList();
                        break;
                }
            },
            // 成功上传图片
            handleThumbSuccess(res, file) {
                this.updateThumbData.imageUrl = URL.createObjectURL(file.raw);
                this.settingItemData.project_thumb = URL.createObjectURL(file.raw);
            },
            // 更新项目名称
            updateNameAndComment() {
                let that = this;
                axios.post(this.settingItemData.updateNameAndCommentUrl, {
                    project_name: this.settingItemData.project_name,
                    project_comment: this.settingItemData.project_comment,
                })
                  .then(function (response) {
                      if (response.data.status === 1) {
                          that.$message({message: response.data.info, type: "success"});
                      } else {
                          that.$message.error(response.data.info);
                      }
                  })
                  .catch(function (error) {
                      console.log(error);
                  });
            },
            // 获取成员列表
            getMemberList() {
                let that = this;
                that.member.loading = true;
                axios.get(this.settingItemData.getMemberListUrl)
                  .then(function (response) {
                      that.member.loading = false;
                      if (response.data.status === 1) {
                          that.member.list = response.data.data.project_user_list
                      } else {
                          that.$message.error(response.data.info);
                      }
                  })
                  .catch(function (error) {
                      console.log(error);
                  });
            },
            // 将成员移出项目
            removeMember(index, user_id) {

            }
        },
        mounted() {
            this.getMemberList();

        }
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

    .avatar-radius {
        width: 32px;
        height: 32px;
        border: 0;
        border-radius: 50px;
    }
</style>