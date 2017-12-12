<!-- 文件浏览器 -->
<template>
    <div class="container">
        <div class="title">
            <span>文件</span>
            <div>
                <a class="el-button el-button--text" @click="createTask.dlgVisible = true">
                    <i class="el-icon-plus"></i> 上传文件
                </a>
            </div>
        </div>
        <el-upload class="upload-demo" drag :action="fileExplorerData.uploadUrl" multiple name="myfile">
            <i class="el-icon-upload"></i>
            <div class="el-upload__text">将文件拖到此处，或<em>点击上传</em></div>
            <div class="el-upload__tip" slot="tip">只能上传jpg/png文件，且不超过500kb</div>
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
                <el-tree :data="data" :props="defaultProps" @node-click="handleNodeClick"></el-tree>

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
                data: [
                    {
                        label: '一级 1',
                        children: [{
                            label: '二级 1-1',
                            children: [{
                                label: '三级 1-1-1'
                            }]
                        }]
                    }, {
                        label: '一级 2',
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
                    }],
                defaultProps: {
                    children: 'children',
                    label: 'label'
                }
            }
        },
        methods: {
            handleNodeClick(data) {
                console.log(data);
            }
        }
    }
</script>

<style scoped>
    .title {
        display: flex;
        justify-content: space-between;

    }

    .title span {
        display: block;
        font-size: 18px;
        padding: 12px 0;
    }

    .explorer {
        display: flex;
        box-sizing: border-box;
        border: 1px solid red;
    }

    .tree {
        flex: 1;
        box-sizing: border-box;
        border: 1px solid blue;
    }

    .preview {
        flex: 3;
        box-sizing: border-box;
        border: 1px solid green;
        margin-left: 10px;
    }
</style>