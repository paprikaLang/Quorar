'use strict';

var mix = require('laravel-mix');

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

mix.js('resources/assets/js/app.js', 'public/js').sass('resources/assets/sass/app.scss', 'public/css').version();

mix.combine(['node_modules/selectize/dist/css/selectize.css', 'node_modules/selectize/dist/css/selectize.bootstrap3.css'], 'public/css/selectize.default.css');

mix.copy('node_modules/selectize/dist/js/standalone/selectize.min.js', 'public/js/selectize.min.js');
//# sourceMappingURL=webpack.mix.js.map