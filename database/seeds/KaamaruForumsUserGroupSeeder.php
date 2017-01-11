<?php

use Illuminate\Database\Seeder;
use Kaamaru\Forums\Users\Group\EloquentUserGroup;

/**
 * Class UserGroupSeeder
 */
class KaamaruForumsUserGroupSeeder extends Seeder
{
    public function run()
    {
        DB::table('lforums_user_group')->delete();

        EloquentUserGroup::create([
            'id' => 1,
            'user_id' => 1,
            'group' => 'Admin'
        ]);

    }
}
