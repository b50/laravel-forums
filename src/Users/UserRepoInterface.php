<?php namespace LaravelForums\Users;

/**
 * Interface UserRepoInterface
 *
 * @package LaravelForums\Forums\Users
 */
interface UserRepoInterface {

	/**
	 * Check weather a user exists by id or email
	 *
	 * @param string $id
	 * @return bool
	 */
	public function exists($id);

	/**
	 * Get user validation errors
	 *
	 * @return array
	 */
	public function getErrors();

	/**
	 * Add topic to user
	 *
	 * @param  $user
	 * @param     $topic
	 * @return
	 */
	public function addTopic($user, $topic);

	/**
	 * Add topic to user
	 *
	 * @param  $userId
	 * @return bool
	 */
	public function addPost($userId);

	/**
	 * @param $userId
	 * @return bool
	 */
	public function deletePost($userId);

	/**
	 * Delete a topic from the user
	 *
	 * @param $topic
	 * @return bool|int
	 */
	public function deleteTopic($topic);

	/**
	 * Get users by their slug
	 *
	 * @param $userSlugs
	 * @return mixed
	 */
	public function getBySlug($userSlugs);

}
