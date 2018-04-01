<!-- 二级导航组件 -->
<template>
    <el-menu :default-active="secondNavData.defaultActive" mode="horizontal">
        <el-menu-item index="看板">
            <a :href="secondNavData.summary" class="el-button el-button--text">看板</a>
        </el-menu-item>
        <el-menu-item index="任务">
            <a :href="secondNavData.task" class="el-button el-button--text">任务</a>
        </el-menu-item>
        <el-menu-item index="WIKI">
            <a :href="secondNavData.wiki" class="el-button el-button--text">WIKI</a>
        </el-menu-item>
        <el-menu-item index="文件">
            <a :href="secondNavData.file" class="el-button el-button--text">文件</a>
        </el-menu-item>
        <el-menu-item index="设置">
            <a :href="secondNavData.setting" class="el-button el-button--text">设置</a>
        </el-menu-item>
    </el-menu>
</template>

<script>
    export default {
        name: "second-nav",
        data() {
            return {}
        },
        methods: {},
        mounted() {
        },
    }
</script>

<style scoped>
    .el-menu {
        display: flex;
        justify-content: center;
    }
</style>