<template>
    <div class="container">
        <article>
            <div class="title">
                <el-input placeholder="请在此输入标题" v-model="current.title"></el-input>
            </div>
            <div class="content">
                <el-input type="textarea" placeholder="请在此输入内容" :rows="25" v-model="current.content"></el-input>
            </div>
            <div class="btn-row">
                <el-button type="primary" @click="save">保存</el-button>
            </div>
        </article>
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
                }
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
        max-width: 800px;
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
</style>