<?php
use Kaamaru\Forums\Users\Group\EloquentUserGroup;

/**
 * Class UserGroupSeeder
 */
class UserGroupSeeder extends Seeder
{
    public function run()
    {
        DB::table('user_group')->delete();

        EloquentUserGroup::create([
            'id' => 1,
            'user_id' => 1,
            'group' => 'Admin'
        ]);

    }
}
