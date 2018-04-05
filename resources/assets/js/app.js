/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

// 引入Elemenet-UI
import ElementUI from 'element-ui'
import 'element-ui/lib/theme-chalk/index.css'
import VueClipboard from 'vue-clipboard2'
import VueQArt from 'vue-qart'

import mavonEditor from 'mavon-editor'
import 'mavon-editor/dist/css/index.css'
// use
Vue.use(mavonEditor)

window.VueQArt = VueQArt;

Vue.use(ElementUI);
Vue.use(VueClipboard);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// Vue.component('example-component', require('./components/ExampleComponent.vue'));

// 导航条组件
let HeaderNav = require('./components/HeaderNav.vue');
HeaderNav.props = ['headerData']; // 声明props
Vue.component('header-nav', HeaderNav);

// 添加二级导航条组件
let SecondNav = require('./components/SecondNav.vue');
SecondNav.props = ['secondNavData']; // 声明props
Vue.component('second-nav', SecondNav);

// 文件浏览器组件
let FileExplorer = require('./components/FileExplorer.vue');
FileExplorer.props = ['fileExplorerData']; // 声明props
Vue.component('file-explorer', FileExplorer);

// 添加项目设置组件
let SettingItem = require('./components/SettingItem.vue');
SettingItem.props = ['settingItemData']; // 声明props
Vue.component('setting-item', SettingItem);

// 任务组件
let TaskItem = require('./components/TaskItem.vue');
TaskItem.props = ['taskItemData']; // 声明props
Vue.component('task-item', require('./components/TaskItem.vue'));

// 个人中心组件
let profile = require('./components/ProfileItem.vue');
profile.props = ['profileData']; // 声明props
Vue.component('profile-item', profile);

// wiki组件
let wiki = require('./components/WikiItem.vue');
wiki.props = ['wikiItemData']; // 声明props
Vue.component('wiki-item', wiki);

// 页脚组件
Vue.component('footer-component', require('./components/FooterComponent.vue'));

// 由页面进行实例化，不在此处操作
// const app = new Vue({
//     el: '#app',
//     data(){
//         return{
//             msg:""
//         }
//     }
// });
