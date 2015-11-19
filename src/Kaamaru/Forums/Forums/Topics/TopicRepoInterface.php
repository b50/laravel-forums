<?php namespace Kaamaru\Forums\Forums\Topics;

use Kaamaru\Forums\Core\Repositories\RepoInterface;

/**
 * Interface TopicRepoInterface
 *
 * @package App\Repositories\Forums
 */
interface TopicRepoInterface extends RepoInterface
{
    /**
     * Get recent topics for forums sidebar
     *
     * @return mixed
     */
    public function getRecent();

    /**
     * Get all topics for all topics page
     *
     * @param $sort
     * @param $order
     * @return mixed
     */
    public function getAll($sort, $order);

    /**
     * Get a topic by it's id
     *
     * @param int $id
     * @param     $user
     * @return EloquentTopic
     */
    public function getForTopicPage($id, $user);

    /**
     * Delete topic
     *
     * @param $id
     * @return bool
     */
    public function delete($id);

    /**
     * Create topic
     *
     * @param int $userId
     * @param        $attributes
     * @return
     */
    public function create($userId, $attributes);

    /**
     * Add a post to the topic
     *
     * @param $topic
     * @param $post
     * @return mixed
     */
    public function addPost($topic, $post);

    /**
     * Make a topic sticky or unsticky
     *
     * @param int $id
     * @return mixed
     */
    public function sticky($id);

    /**
     * Lock or unlock a topic
     *
     * @param int $id
     * @return mixed
     */
    public function lock($id);

    /**
     * @return EloquentTopic
     */
    public function getEmptyTopic();

    /**
     * Get the topic ancestors
     *
     * @param int $id
     * @return array
     */
    public function getAncestors($id);

    /**
     * Move topic to a different forum
     *
     * @param int $topicId
     * @param string $forumPath
     * @return mixed
     */
    public function move($topicId, $forumPath);

    /**
     * Delete a post from the topic
     *
     * @param      $topicId
     * @param null $lastPost Update last post if one is given
     * @return
     */
    public function deletePost($topicId, $lastPost = null);

    /**
     * Update topic title
     *
     * @param int $topicId
     * @param array $data
     * @return void
     */
    public function updateTopic($topicId, $data);

    /**
     * Get topics for a forum
     *
     * @param $forumPath
     * @param $sort
     * @param $direction
     * @return \Illuminate\Pagination\Paginator
     */
    public function getForForum($forumPath, $sort, $direction);

    /**
     * Get topics for a forum
     *
     * @param $forumPath
     * @param $sort
     * @param $direction
     * @return \Illuminate\Pagination\Paginator
     */
    public function getForSuggestionForum($forumPath, $sort, $direction);
}
