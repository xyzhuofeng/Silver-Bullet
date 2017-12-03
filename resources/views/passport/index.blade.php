<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>登录 - 团队协作平台</title>
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ asset('js/element-ui/2.0.5/theme-chalk/index.css') }}">
    <script src="{{ asset('js/vue.js') }}"></script>
    <script src="{{ asset('js/element-ui/2.0.5/index.js') }}"></script>
    <script src="{{ asset('js/axios/0.17.1/axios.min.js') }}"></script>
    <title>Laravel</title>
    <style>
        [v-cloak] {
            display: none;
        }

        .text-center {
            text-align: center;
        }

        #app {
            width: 345px;
            margin: 80px auto 0;
        }

        header {
            text-align: center;
        }

        .btn-login {
            width: 100%;
        }

        a {
            color: #555;
            text-decoration: none;
            font-family: 'Raleway', sans-serif;
        }
    </style>
</head>
<body>
<div id="app" v-cloak>
    <header>
        <a href="{{url('/')}}"><h1>Silver Bullet</h1></a>
    </header>
    <template v-if="loginPage">
        <el-form v-model="form" @submit.native.prevent="login">
            <el-form-item>
                <el-input type="email" v-model="form.email" placeholder="您的邮箱"></el-input>
            </el-form-item>
            <el-input type="password" v-model="form.password" placeholder="您的密码"></el-input>
            <el-row>
                <el-col :span="5" :offset="19">
                    <el-button type="text">忘记密码？</el-button>
                </el-col>
            </el-row>
            <el-form-item>
                <el-button type="primary" native-type="submit" class="btn-login" :loading="isLoading">
                    @{{loginBtn}}
                </el-button>
            </el-form-item>
        </el-form>
        <hr>
        <div class="text-center">
            <el-button type="text">第三方账号登录</el-button>
        </div>
        <div class="text-center">
            <span style="color:#a6a6a6;font-size: 14px;">还没有账号？</span>
            <el-button type="text" @click="loginPage = false">创建新账号</el-button>
        </div>
    </template>
    <template v-if="!loginPage">
        <el-form v-model="form" @submit.native.prevent="register">
            <el-form-item>
                <el-input type="email" v-model="form.email" placeholder="您的邮箱，作为您登录的账号"></el-input>
            </el-form-item>
            <el-form-item>
                <el-input type="password" v-model="form.password" placeholder="你的密码，建议长度6-20位"></el-input>
            </el-form-item>
            <el-form-item>
                <el-input type="text" v-model="form.name" placeholder="您的大名，让同事更容易找到您"></el-input>
            </el-form-item>
            <el-form-item>
                <el-button type="primary" native-type="submit" class="btn-login" :loading="isLoading">
                    @{{registerBtn}}
                </el-button>
            </el-form-item>
        </el-form>
        <hr>
        <div class="text-center">
            <el-button type="text">第三方账号登录</el-button>
        </div>
        <div class="text-center">
            <span style="color:#a6a6a6;font-size: 14px;">已有账号？</span>
            <el-button type="text" @click="loginPage = true">立即登录</el-button>
        </div>
    </template>
</div>
</body>
<script>
    let app = new Vue({
        el: '#app',
        data() {
            return {
                loginPage: true, //默认为登录页
                form: {
                    email: "", // 邮箱
                    password: "", // 密码
                    name: "" // 用户名
                },
                isLoading: false, // 加载中
                loginBtn: "登录",
                registerBtn: "创建账号"
            }
        },
        methods: {
            login() {
                let that = this;
                that.loginBtn = "正在登录...";
                that.isLoading = true;
                axios.post("{{ url('passport/login') }}", that.form)
                  .then(function (response) {
                      that.isLoading = false;
                      that.loginBtn = "登录";
                      if (response.data.status === 1) {
                          window.location.href = response.data.redirect_url;
                      } else {
                          that.$message.error(response.data.info);
                      }
                  })
                  .catch(function (error) {
                      that.isLoading = false;
                      console.log(error);
                  });
            },
            register() {
                let that = this;
                that.registerBtn = "正在创建...";
                that.isLoading = true;
                axios.post("{{ url('passport/register') }}", that.form)
                  .then(function (response) {
                      that.isLoading = false;
                      that.registerBtn = "创建账号";
                      if (response.data.status === 1) {
                          // 弹出说明文字
                          that.$message({
                              message: response.data.info,
                              type: 'success'
                          });
                          if (response.data.redirect_url !== undefined) {
                              window.location.href = response.data.redirect_url;
                          }
                      } else {
                          that.$message.error(response.data.info);
                      }
                  })
                  .catch(function (error) {
                      that.isLoading = false;
                      console.log(error);
                  });
            }
        }
    })
</script>
</html>
