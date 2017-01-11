<?php

use Illuminate\Database\Seeder;

/**
 * Class DatabaseSeeder
 */
class KaamaruForumsDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Eloquent::unguard();

        $this->call('KaamaruForumsTableSeeder');
        $this->call('KaamaruForumsTopicsTableSeeder');
        $this->call('KaamaruForumsPostsTableSeeder');
        $this->call('KaamaruForumsUsersTableSeeder');
        $this->call('KaamaruForumsUserGroupSeeder');
    }
}
