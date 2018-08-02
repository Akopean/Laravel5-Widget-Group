const { mix } = require('laravel-mix');

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

mix.webpackConfig({
    node: {
        fs: 'empty' //https://github.com/webpack-contrib/css-loader/issues/447 issue
    },
});

mix.options({
    	processCssUrls: false,
		fs : 'empty',
	}).sass('resources/assets/scss/app.scss', 'publishable/assets/css')
	  .js('resources/assets/js/app.js', 'publishable/assets/js');
