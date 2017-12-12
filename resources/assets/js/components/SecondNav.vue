<!-- 二级导航组件 -->
<template>
    <el-menu default-active="文件" mode="horizontal"
             style="display: flex; justify-content: center">
        <el-menu-item index="看板">
            <a href="" class="el-button el-button--text">看板</a>
        </el-menu-item>
        <el-menu-item index="任务">
            <a href="" class="el-button el-button--text">任务</a>
        </el-menu-item>
        <el-menu-item index="需求">
            <a href="" class="el-button el-button--text">需求</a>
        </el-menu-item>
        <el-menu-item index="文件">
            <a href="" class="el-button el-button--text">文件</a>
        </el-menu-item>
        <el-menu-item index="审批">
            <a href="" class="el-button el-button--text">审批</a>
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

</style>