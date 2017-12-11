<!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>HTML教程</title>
    <meta name="keywords" content="HTML,ASP,PHP,SQL">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ url(mix('/css/app.css')) }}">
</head>
<body>
<div id="app">
    {{ $php_val }}
    <example-component></example-component>
</div>
</body>
<script src="{{ url(mix('js/app.js')) }}"></script>
<script>
    new Vue({
        el: '#app'
    })
</script>
</html>