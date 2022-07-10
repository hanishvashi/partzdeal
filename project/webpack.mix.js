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

mix.styles([
    '../assets/front/css/font-awesome.min.css',
    '../assets/front/css/icofont.min.css',
    '../assets/front/css/themify-icons.css',
    '../assets/front/css/bootstrap.min.css',
    '../assets/front/css/animate.css',
    '../assets/front/css/owl.carousel.min.css',
    '../assets/front/css/slicknav.min.css',
    '../assets/front/css/meanmenu.min.css',
    '../assets/front/css/fancybox.css',
    '../assets/front/css/bootstrap-slider.min.css',
    '../assets/front/css/global-style.css',
    '../assets/front/css/genius-slider.css',
    '../assets/front/css/perfect-scrollbar.min.css',
    '../assets/front/css/style.css',
    '../assets/front/css/responsive.css',
], '../assets/front/css/all.css');

mix.scripts([
	'../assets/front/js/jquery.min.js',
	'../assets/front/js/bootstrap.min.js',
	'../assets/front/js/jquery.zoom.js',
	'../assets/front/js/zoom-active.js',
	'../assets/front/js/owl.carousel.min.js',
	'../assets/front/js/wow.js',
	'../assets/front/js/jquery.slicknav.min.js',
	'../assets/front/js/jquery.meanmenu.min.js',
	'../assets/front/js/countdown.js',
	'../assets/front/js/fancybox.js',
	'../assets/front/js/bootstrap-slider.min.js',
	'../assets/front/js/genius-slider.js',
	'../assets/front/js/perfect-scrollbar.jquery.min.js',
	'../assets/front/js/notify.js',
	'../assets/front/js/tool-tip.js',
	'../assets/front/js/main.js',
], '../assets/front/js/all.js');
