<!-- 文件浏览器 -->
<template>
    <div class="container">
        <div class="explorer">
            <!-- 目录树 -->
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
                    <el-button type="primary" size="medium" plain @click="delDir">
                        <i class="el-icon-delete el-icon--left"></i>
                        删除目录
                    </el-button>
                </div>
                <el-tree :data="treeData"
                         @node-click="handleNodeClick" ref="tree"
                         :expand-on-click-node="false"
                         :default-expand-all="true"
                         node-key="path" :highlight-current="true">
                </el-tree>
            </div>
            <!-- 文件夹内容预览 -->
            <div class="preview" v-if="!viewFileData.isVisible">
                <el-breadcrumb separator="/">
                    <el-breadcrumb-item v-for="item in breadcrumb" key="breadcrumb">
                        {{item}}
                    </el-breadcrumb-item>
                </el-breadcrumb>
                <el-table :data="previewData" style="width: 100%">
                    <el-table-column label="文件名" sortable>
                        <template slot-scope="scope">
                            <a class="el-button el-button--text" @click="viewFile(scope.row)">{{scope.row.original_name}}</a>
                        </template>
                    </el-table-column>
                    <el-table-column prop="updated_at" label="修改时间" sortable></el-table-column>
                    <el-table-column prop="creator_name" label="创建者" sortable></el-table-column>
                    <el-table-column prop="file_size" label="大小" sortable></el-table-column>
                    <el-table-column label="操作">
                        <template slot-scope="scope">
                            <a :href="scope.row.download_url">
                                <el-button type="text" size="small">下载</el-button>
                            </a>
                            <el-button @click="delFile(scope.row)" type="text" size="small">删除</el-button>
                        </template>
                    </el-table-column>
                </el-table>
            </div>
            <!-- 文件预览窗口 -->
            <div class="viewfile" v-if="viewFileData.isVisible">
                <div>
                    <el-button type="primary" native-type="button" plain @click="viewFileData.isVisible=false">
                        <i class="el-icon-back el-icon--left"></i>返回
                    </el-button>
                </div>
                <iframe :src="viewFileData.src" frameborder="0"></iframe>
            </div>
        </div>
        <el-dialog title="上传文件" width="30%" :visible.sync="uploadDiaVisible">
            <el-upload class="upload-demo" :action="fileExplorerData.uploadUrl"
                       :on-success="uploadSuccess" :file-list="fileList"
                       multiple :data="fileExtData" :before-upload="beforeUpload"
                       name="myfile">
                <el-button size="small" type="primary">点击上传</el-button>
                <div slot="tip" class="el-upload__tip">文件大小不超过500KB。</div>
            </el-upload>
            <span slot="footer" class="dialog-footer">
                <el-button @click="uploadDiaVisible = false">关 闭</el-button>
            </span>
        </el-dialog>
        <el-dialog title="新建文件夹" width="30%" :visible.sync="createDir.diaVisible">
            <el-input placeholder="输入您的新文件夹名" v-model="createDir.newName"></el-input>
            <span slot="footer" class="dialog-footer">
                <el-button @click="createDir.diaVisible = false">关 闭</el-button>
                <el-button type="primary" @click="saveDir">确认</el-button>
            </span>
        </el-dialog>
    </div>
</template>
<script>
    export default {
        name: "file-explorer",
        data() {
            return {
                // 查看文件
                viewFileData: {
                    isVisible: false, // 默认隐藏查看器
                    src: "" // iframe 地址
                },
                // 创建文件夹
                createDir: {
                    diaVisible: false, // 创建文件夹对话框，默认关闭
                    newName: "" // 新文件名
                },
                deleteDirDiaVisible: false, // 删除文件夹窗口
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
            },
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
                        this.createDir.diaVisible = true;
                        break;
                    case "createMD": // 创建Markdown文件
                        break;
                }
            },
            // 删除文件
            delFile(row) {
                let that = this;
                this.$confirm('此操作将永久删除该文件, 是否继续?', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning'
                }).then(() => {
                    axios.post(that.fileExplorerData.deleteFileUrl, {
                        file_id: row.file_id
                    })
                      .then(function (response) {
                          if (response.data.status !== 1) {
                              that.$message.error(response.data.info);
                          } else {
                              that.$message({message: response.data.info, type: "success"});
                              that.updatePreviewDir();
                          }
                      })
                      .catch(function (error) {
                          console.log(error);
                      });
                }).catch(() => {
                    this.$message({
                        type: 'info',
                        message: '已取消删除'
                    });
                });
            },
            // 查看文件
            viewFile(row) {
                this.viewFileData.isVisible = true;
                this.viewFileData.src = this.fileExplorerData.viewFileUrl + "?file_id=" + row.file_id + "&random=" + Math.random()
            },
            // 保存新目录
            saveDir() {
                let that = this;
                axios.post(that.fileExplorerData.saveDirUrl, {
                    virtual_path: that.fileExtData.virtual_path,
                    new_dir: that.createDir.newName
                })
                  .then(function (response) {
                      if (response.data.status !== 1) {
                          that.$message.error(response.data.info);
                      } else {
                          that.treeData = response.data.data;
                          that.$message({message: response.data.info, type: "success"});
                          // 更新虚拟路径
                          that.fileExtData.virtual_path = that.fileExtData.virtual_path + '/' + that.createDir.newName;
                          // 清理数据，关闭弹窗
                          that.createDir.diaVisible = false;
                          that.createDir.newName = "";
                          that.updateExplorerTree();
                          that.updatePreviewDir();
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
                          that.$refs.tree.setCurrentKey(that.fileExtData.virtual_path);
                      }
                  })
                  .catch(function (error) {
                      console.log(error);
                  });
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
            // 删除目录
            delDir() {
                // 防止删除根目录
                if (this.fileExtData.virtual_path === '全部文件') {
                    this.$message.error('无法删除根目录');
                    return;
                }
                let that = this;
                // 获取当前目录路径
                let arr = this.fileExtData.virtual_path.split('/');
                this.$confirm('此操作将永久删除该文件夹及其内容, 是否继续?', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning'
                }).then(() => {
                    axios.post(that.fileExplorerData.deleteDirUrl, {
                        virtual_path: that.fileExtData.virtual_path
                    })
                      .then(function (response) {
                          if (response.data.status !== 1) {
                              that.$message.error(response.data.info);
                          } else {
                              that.$message({message: response.data.info, type: "success"});
                              // 路径重新赋值，自动排除最后一级目录
                              arr.pop();
                              that.fileExtData.virtual_path = arr.join('/');
                              that.updateExplorerTree();
                              that.updatePreviewDir();
                          }
                      })
                      .catch(function (error) {
                          console.log(error);
                      });
                }).catch(() => {
                    this.$message({
                        type: 'info',
                        message: '已取消删除'
                    });
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

    .el-button + .el-button {
        margin-left: 0;
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

    .viewfile {
        flex: 3;
        height: 100%;
        box-sizing: border-box;
        margin-left: 10px;
    }

    .viewfile iframe {
        width: 100%;
        height: 700px;
        margin-top: 15px;
    }
</style>