<?php namespace Kaamaru\Forums\Forums\Topics\Follow;

/**
 * Interface FollowingRepoInterface
 *
 * @package Kaamaru\Forums\Forums\Topics\Follow
 */
interface FollowRepoInterface
{
    /**
     * Follow topic
     *
     * @param $topicId
     * @param $userId
     * @return void
     */
    public function follow($topicId, $userId);

    /**
     * Unfollow topic
     *
     * @param $topicId
     * @param $userId
     * @return void
     */
    public function unfollow($topicId, $userId);
}
