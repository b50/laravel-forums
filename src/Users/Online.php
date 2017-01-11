<?php namespace B50\Forums\Users;

/**
 * Track users online
 *
 * @package B50\Forums\Users
 */
class Online
{
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
        \Cache::put('users_online:user_' . $userId, time(), 5);
    }
}
