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
    mix.copy(
        '../../../vendor/twbs/bootstrap/dist/css/bootstrap.min.css',
        '../../../public/lforums/bootstrap/bootstrap.min.css'
    );
    mix.copy(
        '../../../vendor/twbs/bootstrap/dist/js/bootstrap.min.js',
        '../../../public/lforums/bootstrap/bootstrap.min.js'
    );
    mix.copy(
        '../../../vendor/fortawesome/font-awesome/css/font-awesome.min.css',
        '../../../public/lforums/font-awesome/css/font-awesome.min.css'
    );
    mix.copy(
        '../../../vendor/fortawesome/font-awesome/fonts',
        '../../../public/lforums/font-awesome/fonts'
    );
    mix.copy('database/seeds', '../../../database/seeds/lforums');
    mix.copy('database/migrations', '../../../database/migrations');
    mix.copy('resources/views', '../../../resources/views/lforums');
    mix.copy('resources/assets/sass', '../../../resources/assets/lforums/sass');

    mix.sass(
        'resources/assets/sass/forums.scss',
        '../../../public/lforums/forums.css'
    );
    mix.sass(
        'resources/assets/sass/profile.scss',
        '../../../public/lforums/profile.css'
    );
    mix.sass(
        'resources/assets/sass/editor.scss',
        '../../../public/lforums/editor.css'
    );
});
