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

Vue.use(ElementUI);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// Vue.component('example-component', require('./components/ExampleComponent.vue'));

// 添加导航条组件
let HeaderNav = require('./components/HeaderNav.vue');
HeaderNav.props = ['headerData']; // 声明props
Vue.component('header-nav', HeaderNav);

// 添加二级导航条组件
let SecondNav = require('./components/SecondNav.vue');
SecondNav.props = ['secondNavData']; // 声明props
Vue.component('second-nav', SecondNav);


// 添加文件浏览器组件
let FileExplorer = require('./components/FileExplorer.vue');
FileExplorer.props = ['fileExplorerData']; // 声明props
Vue.component('file-explorer', FileExplorer);

// 添加个人中心组建
let profile = require('./components/Profile.vue');
profile.props = ['profileData']; // 声明props
Vue.component('profile', profile);

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
