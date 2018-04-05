<template>
    <div class="container">
        <el-row>
            <el-col :span="6">
                <h3>目录</h3>
                <el-tree :data="data" node-key="id" default-expand-all></el-tree>
            </el-col>
            <el-col :span="18">
                <article>
                    <div class="title">
                        <el-input placeholder="请在此输入标题" v-model="current.title"></el-input>
                    </div>
                    <div class="content">
                        <mavon-editor v-model="current.content"></mavon-editor>
                    </div>
                    <div class="btn-row">
                        <el-button type="primary" @click="save">保存</el-button>
                        <el-button>添加</el-button>
                        <el-button>删除</el-button>
                    </div>
                </article>
            </el-col>
        </el-row>
    </div>
</template>

<script>
    export default {
        name: "wiki-item",
        data() {
            return {
                current: {
                    title: "",
                    content: "",
                },
                data: [{
                    label: '开发设计文档',
                }, {
                    label: '账号模块',
                }, {
                    label: '成员管理模块',
                }, {
                    label: 'API文档',
                }],
            }
        },
        methods: {
            article() {
                let that = this;
                axios.get(that.wikiItemData.articleUrl)
                  .then(function (response) {
                      if (response.data.status === 1) {
                          that.current = response.data.data;
                      } else {
                          that.$message.error(response.data.info);
                      }
                  })
                  .catch(function (error) {
                      console.log(error);
                  });
            },
            save() {
                let that = this;
                axios.post(this.wikiItemData.saveWikiUrl, that.current)
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
            this.article();
        }
    }
</script>

<style scoped>
    .container {
        width: 100%;
        max-width: 1000px;
        margin: 0 auto;
    }

    article {
        height: 700px;
    }

    .content {
        margin-top: 15px;
    }

    .btn-row {
        margin-top: 15px;
    }

    .markdown-body{
        height: 600px;
    }
</style>