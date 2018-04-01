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

// 导航条组件
let HeaderNav = require('./components/HeaderNav.vue');
HeaderNav.props = ['headerData']; // 声明props
Vue.component('header-nav', HeaderNav);

// 添加二级导航条组件
let SecondNav = require('./components/SecondNav.vue');
SecondNav.props = ['secondNavData']; // 声明props
Vue.component('second-nav', SecondNav);

// 任务组件
let TaskItem = require('./components/TaskItem.vue');
TaskItem.props = ['taskItemData']; // 声明props
Vue.component('task-item', require('./components/TaskItem.vue'));

// 页脚组件
Vue.component('footer-component', require('./components/FooterComponent.vue'));
