<!-- 顶部导航条 -->
<template>
    <el-menu default-active="1" mode="horizontal">
        <el-row>
            <el-col :span="9">
                <el-menu-item index="0">
                    <a href="#" class="el-button el-button--text">
                        <span class="silver">Silver Bullet</span>
                    </a>
                </el-menu-item>
                <el-menu-item index="1"><a class="el-button el-button--text" href="#">项目中心</a>
                </el-menu-item>
                <el-submenu index="2">
                    <template slot="title">我的工作台</template>
                    <el-menu-item index="2-1">选项1</el-menu-item>
                    <el-menu-item index="2-2">选项2</el-menu-item>
                    <el-menu-item index="2-3">选项3</el-menu-item>
                </el-submenu>
            </el-col>
            <el-col :span="6">
                <div class="page-title">
                    <span>从心约App</span>
                </div>
            </el-col>
            <el-col :span="9">
                <div class="page-right-corner">
                    <el-submenu index="3">
                        <template slot="title">您好，庆爷</template>
                        <el-menu-item index="3-1">个人中心</el-menu-item>
                        <el-menu-item index="3-1">账号设置</el-menu-item>
                        <el-menu-item index="louout"><a href=""></a>退出</el-menu-item>
                    </el-submenu>
                    <el-menu-item index="4" class="avatar">
                        <img src="" alt="用户头像">
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
        }
    }
</script>

<style scoped>

</style>