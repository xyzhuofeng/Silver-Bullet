let mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.browserSync('localhost/smartwork/public');

mix.js('resources/assets/js/app.js', 'public/js')
  .sass('resources/assets/sass/app.scss', 'public/css');

mix.setResourceRoot('/smartwork/public/'); // 避免字体文件目录错误

mix.copyDirectory('resources/assets/images', 'public/images'); // 移动图片目录

if (mix.config.inProduction) {
    mix.version();
}