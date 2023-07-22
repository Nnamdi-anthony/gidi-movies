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

mix.setPublicPath("/");

// admin part of the site
mix.js('admin/assets/src/js/gidi-movies-admin.js', 'admin/assets/build/js')
    .sass('admin/assets/src/scss/gidi-movies-admin.scss', 'admin/assets/build/css');

// public part of the site
mix.js('public/assets/src/js/gidi-movies-public.js', 'public/assets/build/js')
    .sass('public/assets/src/scss/gidi-movies-public.scss', 'public/assets/build/css');