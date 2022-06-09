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
mix.webpackConfig({
    resolve: {
        fallback: {
            "fs": false,
            'utf-8-validate': false,
            'bufferutil': false

        },
    },
    target: 'node',

});


mix.js('server.js', './')
    // mix.js('server.js', 'ndeo/js')
    .postCss('resources/css/app.css', 'public/css', [
        //
    ]);