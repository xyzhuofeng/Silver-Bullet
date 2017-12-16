<!-- 文件浏览器 -->
<template>
    <div class="container">
        <div class="title">
            <span>文件</span>
        </div>
        <div class="operation-btn-group">
            <el-dropdown>
                <el-button type="primary" size="medium" plain>
                    <i class="el-icon-circle-plus-outline el-icon--left"></i>
                    新建
                    <i class="el-icon-arrow-down el-icon--right"></i>
                </el-button>
                <el-dropdown-menu slot="dropdown">
                    <el-dropdown-item>Markdown</el-dropdown-item>
                    <el-dropdown-item>文件夹</el-dropdown-item>
                </el-dropdown-menu>
            </el-dropdown>
            <el-button type="primary" size="medium" plain>
                <i class="el-icon-upload el-icon--left"></i>
                上传文件
            </el-button>
        </div>
        <el-upload class="upload-demo" :action="fileExplorerData.uploadUrl"
                   :on-preview="handlePreview" :on-success="uploadSuccess"
                   :on-remove="handleRemove"
                   multiple :data="fileExtData" :before-upload="beforeUpload"
                   :file-list="fileList"
                   name="myfile">
            <el-button size="small" type="primary">点击上传</el-button>
            <div slot="tip" class="el-upload__tip">只能上传jpg/png文件，且不超过500kb</div>
        </el-upload>
        <div class="explorer">
            <div class="tree">
                <el-tree :data="treeData" :props="defaultProps"
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
                    <el-table-column prop="original_name" label="文件名"></el-table-column>
                    <el-table-column prop="updated_at" label="修改时间"></el-table-column>
                    <el-table-column prop="creator_name" label="创建者"></el-table-column>
                    <el-table-column prop="file_size" label="大小"></el-table-column>
                </el-table>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        name: "file-explorer",
        data() {
            return {
                // 上传文件列表
                fileList: [],
                // 虚拟文件夹路径
                fileExtData: {
                    virtual_path: "全部文件"
                },
                // 目录树数据
                treeData: [
                    {
                        label: "全部文件",
                        path: "全部文件",
                        children: [
                            {
                                label: '项目资料',
                                path: "全部文件/项目资料",
                            }, {
                                label: '项目资料2',
                                path: "全部文件/项目资料2",
                            }
                        ]
                    }
                ],
                // 文件目录数据
                previewData: [],
                defaultProps: {
                    children: 'children',
                    label: 'label'
                }
            }
        },
        computed: {
            // 用于面包屑导航的计算属性，返回一个路径数组
            breadcrumb: function () {
                let arr = this.fileExtData.virtual_path.split("/");
                console.log(arr);
                return arr;
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
            handleNodeClick(data) {
                this.fileExtData.virtual_path = data.path;
                // console.log(data);
                this.updatePreviewDir();
                console.log(JSON.stringify(this.treeData));
            },
            handleRemove(file, fileList) {
                console.log(file, fileList);
            },
            handlePreview(file) {
                console.log(file);
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
        display: flex;
        flex-direction: column;
        height: 100%;
        max-height: 100%;
        overflow-y: auto;
    }

    .title span {
        display: block;
        font-size: 18px;
        padding: 12px 0;
    }

    .el-dropdown + .el-dropdown {
        margin-left: 15px;
    }

    .el-icon-arrow-down {
        font-size: 12px;
    }

    .explorer {
        flex: 1;
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