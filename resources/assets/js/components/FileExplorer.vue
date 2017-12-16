<!-- 文件浏览器 -->
<template>
    <div class="container">
        <div class="explorer">
            <div class="tree">
                <div class="operation-btn-group">
                    <el-dropdown @command="handleCommand">
                        <el-button type="primary" size="medium" plain>
                            <i class="el-icon-circle-plus-outline el-icon--left"></i>
                            新建
                            <i class="el-icon-arrow-down el-icon--right"></i>
                        </el-button>
                        <el-dropdown-menu slot="dropdown">
                            <el-dropdown-item command="createDirMD">
                                Markdown
                            </el-dropdown-item>
                            <el-dropdown-item command="createDir">
                                文件夹
                            </el-dropdown-item>
                        </el-dropdown-menu>
                    </el-dropdown>
                    <el-button type="primary" size="medium" plain @click="fileList = []; uploadDiaVisible = true">
                        <i class="el-icon-upload el-icon--left"></i>
                        上传文件
                    </el-button>
                </div>
                <el-tree :data="treeData"
                         @node-click="handleNodeClick" ref="tree"
                         :expand-on-click-node="false"
                         :default-expanded-keys="['全部文件']"
                         node-key="path">
                </el-tree>
            </div>
            <div class="preview">
                <el-breadcrumb separator="/">
                    <el-breadcrumb-item v-for="item in breadcrumb" key="breadcrumb">
                        {{item}}
                    </el-breadcrumb-item>
                </el-breadcrumb>
                <el-table :data="previewData" style="width: 100%">
                    <el-table-column prop="original_name" label="文件名" sortable>
                    </el-table-column>
                    <el-table-column prop="updated_at" label="修改时间" sortable></el-table-column>
                    <el-table-column prop="creator_name" label="创建者" sortable></el-table-column>
                    <el-table-column prop="file_size" label="大小" sortable></el-table-column>
                </el-table>
            </div>
        </div>
        <el-dialog title="上传文件" width="30%" :visible.sync="uploadDiaVisible">
            <el-upload class="upload-demo" :action="fileExplorerData.uploadUrl"
                       :on-success="uploadSuccess" :file-list="fileList"
                       multiple :data="fileExtData" :before-upload="beforeUpload"
                       name="myfile">
                <el-button size="small" type="primary">点击上传</el-button>
                <div slot="tip" class="el-upload__tip">只能上传jpg/png文件，且不超过500kb</div>
            </el-upload>
            <span slot="footer" class="dialog-footer">
                <el-button @click="uploadDiaVisible = false">关 闭</el-button>
            </span>
        </el-dialog>
        <el-dialog title="新建文件夹" width="30%" :visible.sync="createDirDiaVisible">
            <el-input placeholder="输入您的新文件夹名" value=""></el-input>
            <span slot="footer" class="dialog-footer">
                <el-button @click="createDirDiaVisible = false">关 闭</el-button>
                <el-button type="primary" @click="createDirDiaVisible = false">确认</el-button>
            </span>
        </el-dialog>
    </div>
</template>
<script>
    export default {
        name: "file-explorer",
        data() {
            return {
                // 创建文件夹对话框
                createDirDiaVisible: false, // 默认关闭
                // 上传对话框
                uploadDiaVisible: false, // 默认关闭
                // 上传文件列表
                fileList: [],
                // 虚拟文件夹路径
                fileExtData: {
                    virtual_path: "全部文件"
                },
                // 目录树数据
                treeData: [],
                // 文件目录数据
                previewData: []
            }
        },
        computed: {
            // 用于面包屑导航的计算属性，返回一个路径数组
            breadcrumb: function () {
                return this.fileExtData.virtual_path.split("/");
            }
        },
        methods: {
            // 上传前更新虚拟路径
            beforeUpload() {
                // 文件路径
                this.fileExtData.virtual_path = this.fileExtData.virtual_path + "";
            },
            // 成功上传的处理
            uploadSuccess() {
                this.updatePreviewDir(); // 刷新目录预览
            },
            // 点击目录树节点
            handleNodeClick(data) {
                this.fileExtData.virtual_path = data.path;
                // 更新目录预览内容
                this.updatePreviewDir();
            },
            // 下拉列表点击事件
            handleCommand(command) {
                switch (command) {
                    case "createDir": // 创建文件夹
                        this.createDirDiaVisible = true;
                        break;
                    case "createMD": // 创建Markdown文件
                        break;
                }
            },
            // 更新目录预览
            updatePreviewDir() {
                let that = this;
                axios.post(that.fileExplorerData.previewDirUrl, {
                    virtual_path: that.fileExtData.virtual_path
                })
                  .then(function (response) {
                      if (response.data.status !== 1) {
                          that.$message.error(response.data.info);
                      } else {
                          that.previewData = response.data.data;
                      }
                  })
                  .catch(function (error) {
                      console.log(error);
                  });
            },
            // 更新目录树
            updateExplorerTree() {
                let that = this;
                axios.get(that.fileExplorerData.treeUrl)
                  .then(function (response) {
                      if (response.data.status !== 1) {
                          that.$message.error(response.data.info);
                      } else {
                          that.treeData = response.data.data;
                      }
                  })
                  .catch(function (error) {
                      console.log(error);
                  });
            }
        },
        mounted() {
            // 更新目录树
            this.updateExplorerTree();
            // 更新目录预览
            this.updatePreviewDir();

        }
    }
</script>

<style scoped>
    .container {
        height: 100%;
    }

    .el-dropdown + .el-dropdown {
        margin-left: 15px;
    }

    .el-icon-arrow-down {
        font-size: 12px;
    }

    .explorer {
        height: 100%;
        display: flex;
        box-sizing: border-box;
    }

    .tree {
        flex: 1;
        height: 100%;
        box-sizing: border-box;
    }

    .preview {
        flex: 3;
        height: 100%;
        box-sizing: border-box;
        margin-left: 10px;
    }
</style>