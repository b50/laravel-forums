<?php namespace B50\Forums;

use Illuminate\Database\Seeder;

/**
 * Class DatabaseSeeder
 */
class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Eloquent::unguard();

        $this->call(ForumsTableSeeder::class);
        $this->call(TopicsTableSeeder::class);
        $this->call(PostsTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(UserGroupSeeder::class);
    }
}
