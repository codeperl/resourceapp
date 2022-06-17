const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

// FRONT FACING PAGES JAVASCRIPT COMPILATION, MINIFICATION.
mix.js('resources/js/web/front/app.js', 'public/js/web/front')
    .js('resources/js/web/front/main.js', 'public/js/web/front')
    .js('resources/js/web/front/custom.js', 'public/js/web/front');

// FRONT FACING PAGES CSS COMPILATION, MINIFICATION.
mix.sass('resources/scss/web/front/app.scss', 'public/css/web/front', [])
    .sass('resources/scss/web/front/fonts.scss', 'public/css/web/front', [])
    .sass('resources/scss/web/front/contrast.scss', 'public/css/web/front', [])
    .version();

// ADMIN JAVASCRIPT COMPILATION, MINIFICATION.
mix.js('resources/js/admin/app.js', 'public/js/admin').vue().version();

// ADMIN CSS COMPILATION, MINIFICATION.
mix.sass('resources/scss/admin/app.scss', 'public/css/admin', [])
    .version();

// OTHER OPERATIONS.
mix.postCss('resources/css/web/front/app.css', 'public/css/web/front', [])
    .postCss('resources/css/web/front/style.css', 'public/css/web/front', [])
    .postCss('resources/css/web/front/front.css', 'public/css/web/front', [])
    .postCss('resources/css/error.css', 'public/css', [])
    .copyDirectory('resources/fonts', 'public/fonts')
    .copyDirectory('resources/images', 'public/images').version();
