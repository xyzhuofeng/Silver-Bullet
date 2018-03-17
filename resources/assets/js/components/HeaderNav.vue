<!-- 顶部导航条 -->
<template>
    <el-menu default-active="1" mode="horizontal" @select="handleSelect">
        <el-row>
            <el-col :span="9">
                <el-menu-item index="0">
                    <a :href="headerData.homeUrl" class="el-button el-button--text">
                        <span class="silver">Silver Bullet</span>
                    </a>
                </el-menu-item>
                <el-menu-item index="1">
                    <a class="el-button el-button--text" :href="headerData.projectUrl">项目中心</a>
                </el-menu-item>
                <!--<el-submenu index="2">-->
                    <!--<template slot="title">我的工作台（待完成）</template>-->
                    <!--<el-menu-item index="2-1">选项1</el-menu-item>-->
                    <!--<el-menu-item index="2-2">选项2</el-menu-item>-->
                    <!--<el-menu-item index="2-3">选项3</el-menu-item>-->
                <!--</el-submenu>-->
            </el-col>
            <el-col :span="6">
                <div class="header-nav-title">
                    <span>{{headerData.projectName}}</span>
                </div>
            </el-col>
            <el-col :span="9">
                <div class="header-right-corner">
                    <el-submenu index="3">
                        <template slot="title">您好，{{headerData.username}}</template>
                        <el-menu-item index="个人中心">个人中心</el-menu-item>
                        <el-menu-item index="退出"><a href=""></a>退出</el-menu-item>
                    </el-submenu>
                    <el-menu-item index="个人中心" class="avatar">
                        <img :src="headerData.avatarUrl" alt="用户头像">
                    </el-menu-item>
                </div>
            </el-col>
        </el-row>
    </el-menu>
</template>

<script>
    export default {
        name: "header-nav",
        data() {
            return {}
        },
        methods: {
            // 导航条选择相应方法
            handleSelect: function (key, keyPath) {
                switch (key) {
                    case '退出':
                        window.location.href = this.headerData.logoutUrl;
                        break;
                    case '个人中心':
                        window.location.href = this.headerData.usercenterUrl;
                        break;
                }
            }
        },
        mounted() {
        }
    }
</script>

<style scoped>
    /*header菜单样式*/
    .el-menu .el-row {
        outline: none;
    }

    .header-nav-title {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 60px;
    }

    .header-nav-title span {
        display: block;
        font-size: 20px;
    }

    .header-right-corner {
        display: flex;
        justify-content: flex-end;
        height: 60px;
        padding-right: 20px;
    }

    .avatar {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .avatar img {
        display: block;
        width: 40px;
        height: 40px;
        border: 0;
        border-radius: 100px;
        -moz-box-shadow: 0 0 6px #666;
        -webkit-box-shadow: 0 0 6px #666;
        box-shadow: 0 0 6px #666;
    }
</style>