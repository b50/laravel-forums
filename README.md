Laravel Forums
=======
A forums for laravel.

I'm converting this from a personal laravel 4.2 application to a laravel 5 package. 
I'm about 50% done upgrading so far.
##Install
    gulp --gulpfile vendor/b50/laravel-forums/gulpfile.js
    artisan migrate
    artisan db:seed --class B50\\Forums\\DatabaseSeeder