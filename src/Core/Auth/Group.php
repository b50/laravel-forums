<?php namespace B50\Forums\Core\Auth;

use B50\Forums\Users\Group\UserGroupRepoInterface;

/**
 * Bouncer to block members without the required group or permission
 *
 * @package B50\Forums\Core\Auth\Guard
 */
class Group
{
    /**
     * @param UserGroupRepoInterface $group
     */
    public function __construct(UserGroupRepoInterface $group)
    {
        $this->group = $group;
    }

    /**
     * Get the groups
     *
     * @return mixed
     */
    public function getGroups()
    {
        if (!\Auth::check()) {
            return [];
        }

        $dbGroups = \Cache::remember('groups:user_' . \Auth::user()->id, 10, function () {
            return $this->dbGroups();
        });

        $groups = [];

        foreach ($dbGroups as $key => $group) {
            $groups[] = \App::make('B50\Forums\Core\Auth\Groups\\' . $group);
        }

        // Return group objects
        return $groups;
    }

    /**
     * Get groups from the database
     *
     * @return mixed
     */
    protected function dbGroups()
    {
        // Get groups from the database
        $dbGroups = $this->group->getForUser(\Auth::user()->id);

        // Get groups from UserGroup object
        $groups = [];

        foreach ($dbGroups as $group) {
            $groups[] = $group->group;
        }

        return $groups;
    }

    public function addUser($group, $userId)
    {
    }
}
