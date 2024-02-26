const mix = require('laravel-mix');

const newLocal = 'resources/css/scripts.css';
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
 mix    .js('resources/js/admin/app.js', 'public/js/admin')
        .js('resources/js/aluno/app.js', 'public/js/aluno')
        .js('resources/js/professor/app.js', 'public/js/professor')
        .js('resources/js/whats/app.js', 'public/js/whats')
        .js('resources/js/scripts.js', 'public/js')
        .sass('resources/sass/app.scss', 'public/css')
        .css('resources/css/style.css', 'public/css')
        // .js('resources/js/app.js', 'public/js')
        .sourceMaps()
        .vue({ version : 2});
