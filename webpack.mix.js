const mix = require('laravel-mix');
const { rule } = require('postcss');

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
    .sass('resources/sass/app.scss', 'public/css')
    .version();

mix.webpackConfig({
    module: {
        rules: [
            {
                test: /\.(woff|woff2|eot|ttf|svg)$/,
                use: {
                    loader: 'url-loader',
                }
            }
        ]
    }
});
