<?php namespace LaravelForums\Users\Group;

/**
 * Interface UserGroupInterface
 *
 * @package LaravelForums\Users
 */
interface UserGroupRepoInterface {

	/**
	 * Get groups for the user
	 *
	 * @param int $userId
	 * @return mixed
	 */
	public function getForUser($userId);

	/**
	 * Add user to group
	 *
	 * @param $group
	 * @param $userId
	 * @return bool
	 */
	public function addToGroup($group, $userId);
	
}
