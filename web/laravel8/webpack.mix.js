const mix = require('laravel-mix');
require('mix-tailwindcss');

mix.browserSync({
    proxy: '0.0.0.0:8081', // アプリの起動アドレス
    open: false // ブラウザを自動で開かない
})
    .js('resources/js/app.js', 'public/js')
    .vue()
    .version()
    .sass('resources/sass/app.scss', 'public/css')
    .tailwind();
