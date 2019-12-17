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

mix.js('resources/assets/js/app.js', 'public/js')
   .sass('resources/assets/sass/app.scss', 'public/css').version()
   .copyDirectory('resources/assets/editor/js', 'public/js')
   .copyDirectory('resources/assets/editor/css', 'public/css')
   ;


mix.browserSync({
    proxy: 'larabbs.test',
    files: ['app/**/*', 'public/**/*', 'resources/views/**/*'],
    port: 8900,
    notify: false, //刷新是否提示
    open: false //是否自动打开页面
});