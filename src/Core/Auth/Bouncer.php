<?php namespace LaravelForums\Core\Auth;

use LaravelForums\Users\Group\UserGroupRepoInterface;

/**
 * Bouncer to block members without the required group or permission
 *
 * @package LaravelForums\Core\Auth\Guard
 */
class Bouncer {

	/**
	 * @param UserGroupRepoInterface $groupRepo
	 * @param Group                  $group
	 */
	public function __construct(UserGroupRepoInterface $groupRepo, Group $group)
	{
		$this->groupRepo = $groupRepo;
		$this->group = $group;
	}

	/**
	 * See weather the user in in the group
	 *
	 * @param string $groupName
	 * @return bool
	 */
	public function inGroup($groupName)
	{
		foreach ($this->group->getGroups() as $group)
		{
			if (get_class($group) == 'LaravelForums\\Auth\\Groups\\'.$groupName)
			{
				return true;
			}
		}
		return false;
	}

	/**
	 * See weather a user has a permission
	 *
	 * @param $permission
	 * @return bool
	 */
	public function hasPermission($permission)
	{
		foreach ($this->group->getGroups() as $group)
		{
			foreach ($group->permissions as $groupPermission)
			{
				if ($groupPermission == $permission or $groupPermission == '*')
				{
					return true;
				}

				if (ends_with($groupPermission, '*') and starts_with($permission, substr($groupPermission, 0, -1)))
				{
					return true;
				}
			}
		}

		return false;
	}

	/**
	 * Is owner
	 *
	 * @param mixed $model
	 * @return bool
	 */
	public function isOwner($model)
	{
		return \Auth::user()->id == $model->user_id;
	}

	/**
	 * Has permission or is owner
	 *
	 * @param string $permission
	 * @param mixed  $model
	 * @return bool
	 */
	public function hasPermissionOrIsOwner($permission, $model)
	{
		return $this->hasPermission($permission) or $this->isOwner($model);
	}

	public function addToGroup($group, $userId)
	{
		$this->groupRepo->addToGroup($group, $userId);
	}

}
