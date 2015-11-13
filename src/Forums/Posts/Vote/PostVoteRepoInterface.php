<?php namespace LaravelForums\Forums\Posts\Vote;

/**
 * Interface VoteRepoInterface
 *
 * @package LaravelForums\Forums\Posts\Votes
 */
interface PostVoteRepoInterface {

	/**
	 * Get post vote
	 *
	 * @param $postId
	 * @param $userId
	 * @return mixed
	 */
	public function getForPost($postId, $userId);

	/**
	 * Delete post vote by it's id
	 *
	 * @param $id
	 * @return void
	 */
	public function deleteById($id);

	/**
	 * Increment post vote count
	 *
	 * @param $postId
	 * @param $userId
	 * @return void
	 */
	public function incrementVote($postId, $userId);

	/**
	 * Decrement post vote count
	 *
	 * @param $postId
	 * @param $userId
	 * @return void
	 */
	public function decrementVote($postId, $userId);

}
