<?php
use LaravelForums\Users\EloquentUser;

/**
 * Class UsersTableSeeder
 */
class UsersTableSeeder extends Seeder {

	public function run()
	{
		DB::table('users')->delete();

		EloquentUser::create([
			'id' => 1,
			'username' => 'Calum',
			'email' => 'calumks@live.com',
			'slug' => 'calum',
			'password' => Hash::make(1234),
			'posts' => 2,
			'topics' => 2,
			'activated_at' => time(),
			'created_at' => time(),
			'updated_at' => time(),
			'deleted_at' => time(),
			'signature' => 'Hello this is a signature...',
		]);

		EloquentUser::create([
			'id' => 2,
			'username' => 'Test User',
			'email' => 'calumks@gmail.com',
			'slug' => 'test-user',
			'password' => Hash::make(1234),
			'posts' => 1,
			'topics' => 1,
			'created_at' => time(),
			'updated_at' => time(),
			'deleted_at' => time(),
		]);

		EloquentUser::create([
			'id' => 3,
			'username' => 'bob',
			'email' => 'test@example.com',
			'slug' => 'bob',
			'password' => Hash::make(1234),
			'posts' => 1,
			'topics' => 1,
			'created_at' => time(),
			'updated_at' => time(),
			'deleted_at' => time(),
		]);
	}

}
