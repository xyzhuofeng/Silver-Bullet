<!-- 文件浏览器 -->
<template>
    <div class="container">
        <div class="title">
            <span>文件</span>
        </div>
        <el-upload class="upload-demo" :action="fileExplorerData.uploadUrl"
                   :on-preview="handlePreview"
                   :on-remove="handleRemove"
                   multiple :data="fileExtData" :before-upload="beforeUpload"
                   :file-list="fileList">
            <el-button size="small" type="primary">点击上传</el-button>
            <div slot="tip" class="el-upload__tip">只能上传jpg/png文件，且不超过500kb</div>
        </el-upload>
        <el-breadcrumb separator="/">
            <el-breadcrumb-item :to="{ path: '/' }">首页</el-breadcrumb-item>
            <el-breadcrumb-item>活动管理</el-breadcrumb-item>
            <el-breadcrumb-item>活动列表</el-breadcrumb-item>
            <el-breadcrumb-item>活动详情</el-breadcrumb-item>
        </el-breadcrumb>
        <div class="explorer">
            <div class="tree">
                目录树
                <el-tree :data="treeData" :props="defaultProps" @node-click="handleNodeClick" ref="tree"></el-tree>
            </div>
            <div class="preview">
                文件预览
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
                                path:"全部资料/工作室资料",
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
            handleNodeClick(data) {
                this.fileExtData.virtual_path = data.path;
                console.log(data);
            },
            handleRemove(file, fileList) {
                console.log(file, fileList);
            },
            handlePreview(file) {
                console.log(file);
            }
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
        border: 1px solid red;
    }

    .tree {
        flex: 1;
        height: 100%;
        box-sizing: border-box;
        border: 1px solid blue;
    }

    .preview {
        flex: 3;
        height: 100%;

        box-sizing: border-box;
        border: 1px solid green;
        margin-left: 10px;
    }
</style>