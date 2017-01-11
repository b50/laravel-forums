<?php namespace B50\Forums;

use Illuminate\Database\Seeder;
use B50\Forums\Users\Group\EloquentUserGroup;

/**
 * Class UserGroupSeeder
 */
class UserGroupSeeder extends Seeder
{
    public function run()
    {
        \DB::table('lforums_user_group')->delete();

        EloquentUserGroup::create([
            'id' => 1,
            'user_id' => 1,
            'group' => 'Admin'
        ]);

    }
}
