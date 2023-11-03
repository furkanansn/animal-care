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

mix.js('resources/js/app.js', 'public/js')
    .postCss('resources/css/app.css', 'public/css', [
        //
    ]);

mix.scripts([
    'public/js/vendor/*.js',
    'public/js/dore-plugins/*.js',
    'public/js/vendor/landing-page/*.js',
    'public/js/*.js',
], 'public/js/all.min.js')

mix.styles([
    'public/css/vendor/*.css',
    'public/css/*.css',
], 'public/css/all.min.css')

