<?php namespace Kaamaru\Forums\Forums\Posts\Report;

/**
 * Interface VoteRepoInterface
 *
 * @package Kaamaru\Forums\Forums\Posts\Votes
 */
interface PostReportRepoInterface
{
    /**
     * Report post
     *
     * @param $postId
     * @param $userId
     * @return void
     */
    public function report($postId, $userId);

    /**
     * Get report for a post
     *
     * @param $postId
     * @param $userId
     * @return mixed
     */
    public function getByPostId($postId, $userId);
}
