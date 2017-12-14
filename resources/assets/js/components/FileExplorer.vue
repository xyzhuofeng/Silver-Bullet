<!-- 文件浏览器 -->
<template>
    <div class="container">
        <div class="title">
            <span>文件</span>
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
                目录树
                <el-tree :data="treeData" :props="defaultProps" @node-click="handleNodeClick" ref="tree"></el-tree>
            </div>
            <div class="preview">
                路径
                <el-breadcrumb separator="/">
                    <el-breadcrumb-item :to="{ path: '/' }">全部文件</el-breadcrumb-item>
                    <el-breadcrumb-item>项目文件夹</el-breadcrumb-item>
                    <!--<el-breadcrumb-item>活动列表</el-breadcrumb-item>-->
                    <!--<el-breadcrumb-item>活动详情</el-breadcrumb-item>-->
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
                                label: '工作室资料',
                                path: "全部资料/工作室资料",
                                children: [{
                                    label: '二级 1-1',
                                    children: [{
                                        label: '三级 1-1-1'
                                    }]
                                }]
                            }, {
                                label: '项目资料',
                                children: [{
                                    label: '二级 2-1',
                                    children: [{
                                        label: '三级 2-1-1'
                                    }]
                                }, {
                                    label: '二级 2-2',
                                    children: [{
                                        label: '三级 2-2-1'
                                    }]
                                }]
                            }, {
                                label: '一级 3',
                                children: [{
                                    label: '二级 3-1',
                                    children: [{
                                        label: '三级 3-1-1'
                                    }]
                                }, {
                                    label: '二级 3-2',
                                    children: [{
                                        label: '三级 3-2-1'
                                    }]
                                }]
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
        methods: {
            beforeUpload() {
                // 文件路径
                this.fileExtData.virtual_path = this.fileExtData.virtual_path + "";
            },
            uploadSuccess() {
                this.updatePreviewDir();
            },
            handleNodeClick(data) {
                this.fileExtData.virtual_path = data.path;
                console.log(data);
            },
            handleRemove(file, fileList) {
                console.log(file, fileList);
            },
            handlePreview(file) {
                console.log(file);
            },
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
            }
        },
        mounted() {
            this.updatePreviewDir();
        }
    }
</script>

<style scoped>
    .container {
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .title span {
        display: block;
        font-size: 18px;
        padding: 12px 0;
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