<?php

use Illuminate\Database\Seeder;
use Kaamaru\Forums\Users\EloquentUser;

/**
 * Class UsersTableSeeder
 */
class KaamaruForumsUsersTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('lforums_users')->delete();

        EloquentUser::create([
            'id' => 1,
            'posts' => 2,
            'topics' => 2,
            'signature' => 'Hello this is a signature...',
        ]);

        EloquentUser::create([
            'id' => 2,
            'posts' => 1,
            'topics' => 1,
        ]);

        EloquentUser::create([
            'id' => 3,
            'posts' => 1,
            'topics' => 1,
        ]);
    }
}
