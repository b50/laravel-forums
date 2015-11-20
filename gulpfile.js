var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    mix.sass('../../../src/resources/assets/sass/forums.scss',
        '../../../public/css/kaamaru/laravel-forums/forums.css');
    mix.sass('../../../src/resources/assets/sass/profile.scss',
        '../../../public/css/kaamaru/laravel-forums/profile.css');
    mix.sass('../../../src/resources/assets/sass/editor.scss',
        '../../../public/css/kaamaru/laravel-forums/editor.css');
    mix.copy('../../../vendor/twbs/bootstrap/dist/css/bootstrap.min.css',
        '../../../public/css/kaamaru/laravel-forums/bootstrap.min.css');
    mix.copy('../../../vendor/twbs/bootstrap/dist/js/bootstrap.min.js',
        '../../../public/js/kaamaru/laravel-forums/bootstrap.min.js')
    mix.copy('src/database', '../../../database');
    mix.copy('src/resources/views', '../../../resources/views/kaamaru/laravel-forums');
    mix.copy('src/resources/assets/sass', '../../../resources/assets/sass/kaamaru/laravel-forums');
});
