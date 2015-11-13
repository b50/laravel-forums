<?php namespace LaravelForums\Users;

/**
 * Track users online
 *
 * @package LaravelForums\Users
 */
class Online {

	public function updateSeenTime($userId)
	{
		// TODO
	}

	/**
	 * Update a user's online time
	 *
	 * @param $userId
	 */
	public function update($userId)
	{
		\Cache::put('users_online:user_'.$userId, time(), 5);
	}
	
}
