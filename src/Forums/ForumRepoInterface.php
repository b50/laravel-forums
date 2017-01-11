<?php namespace Kaamaru\Forums\Forums;

use Kaamaru\Forums\Core\Repositories\RepoInterface;
use Kaamaru\Forums\Topics\EloquentTopic;

/**
 * Interface ForumRepoInterface
 *
 * @package App\Repositories\Forums
 */
interface ForumRepoInterface extends RepoInterface
{
    /**
     * Get a parent's children and grandchildren
     *
     * @return mixed
     */
    public function getForums();

    /**
     * Get forum by it's path
     *
     * @param string $path
     * @return EloquentForum|static|null
     */
    public function getByPath($path);

    /**
     *  Change to Eloquent when when increment supports multiple columns
     *
     * @param array $ids forum ids
     * @param EloquentTopic $topic
     * @param bool $lastPost update the last post
     * @return
     */
    public function addTopic(array $ids, EloquentTopic $topic, $lastPost = true);

    /**
     *  Change to Eloquent when when increment supports multiple columns
     *
     * @param array $ids forum id
     */
    public function addPost(array $ids, $post);

    /**
     * Get a forums tree
     *
     * @return array
     */
    public function getTree();

    /**
     * Delete a post from forums
     *
     * @param array $ids
     * @return mixed
     */
    public function deletePost(array $ids);

    /**
     * Delete topic
     *
     * @param EloquentTopic $topic
     * @return int
     */
    public function deleteTopic(EloquentTopic $topic);

    /**
     * Get subforums for the given forum
     *
     * @param $forum
     * @return array|static[]
     */
    public function getSubforums($forum);
}
