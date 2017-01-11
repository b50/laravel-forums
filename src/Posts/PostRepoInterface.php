<?php namespace B50\Forums\Posts;

use B50\Forums\Core\Repositories\RepoInterface;

/**
 * Interface PostRepoInterface
 *
 * @package App\Repositories\Forums
 */
interface PostRepoInterface extends RepoInterface
{
    /**
     * Get recent topics for forums sidebar
     *
     * @return array|mixed|static[]
     */
    public function getRecent();

    /**
     * Create a post
     *
     * @param array $input
     * @return EloquentPost
     */
    public function create($input);

    /**
     * Edit post
     *
     * @param string $content
     * @param int $postId
     * @return mixed
     */
    public function edit($content, $postId);

    /**
     * Get a post's page
     *
     * @param $post
     * @return int
     */
    public function getPostPage($post);

    /**
     * @return EloquentPost
     */
    public function getEmptyPost();

    /**
     * Get the first post in a topic's id
     *
     * @param $topicId
     * @return mixed
     */
    public function getFirstPostId($topicId);

    /**
     * Get a topic's last post
     *
     * @param $topicId
     * @return mixed
     */
    public function getLastPost($topicId);

    /**
     * Vote post up
     *
     * @param int $postId
     * @return void
     */
    public function incrementVote($postId);

    /**
     * Vote post down
     *
     * @param int $postId
     * @return void
     */
    public function decrementVote($postId);

    /**
     * Find out if a post is the first post in the topic
     *
     * @param $post
     * @return bool
     */
    public function isFirst($post);
}
