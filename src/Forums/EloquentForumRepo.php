<?php namespace B50\Forums\Forums;

use B50\Forums\Core\Repositories\EloquentRepo;
use B50\Forums\Topics\EloquentTopic;

/**
 * Forum Model
 *
 * @package    Application
 * @category   Model
 */
class EloquentForumRepo extends EloquentRepo implements ForumRepoInterface
{
    /**
     * @param EloquentForum $model
     */
    public function __construct(EloquentForum $model)
    {
        $this->model = $model;
    }

    /**
     * {@inheritDoc}
     */
    public function getByPath($path)
    {
        return $this->model
            ->where('path', $path)
            ->first(['id', 'slug', 'name', 'path']);
    }

    /**
     * {@inheritDoc}
     */
    public function addTopic(array $ids, EloquentTopic $topic, $lastPost = true)
    {
        // Clean and convert ids
        $ids = implode(',', array_filter($ids, 'is_numeric'));

        if ($lastPost) {
            $query = "UPDATE forums
			      SET posts = posts + ?, topics_count = topics_count + 1, last_topic = ?
			      WHERE id IN ($ids)";

            \DB::update($query, [$topic->posts_count, $topic->id]);
        } else {
            $query = "UPDATE forums
			      SET posts = posts + ?, topics_count = topics_count + 1
			      WHERE id IN ($ids)";

            \DB::update($query, [$topic->posts_count]);
        }

    }

    /**
     * {@inheritDoc}
     */
    public function deleteTopic(EloquentTopic $topic)
    {
        // Clean and convert ids
        $ids = implode(',', array_filter($topic->pathExplode(), 'is_numeric'));

        $query = "UPDATE forums
			      SET posts = posts - ?, topics_count = topics_count - 1
			      WHERE id IN ($ids)";

        return \DB::update($query, [$topic->posts_count]);
    }

    /**
     * {@inheritDoc}
     */
    public function addPost(array $ids, $post)
    {
        $this->model
            ->whereIn('id', $ids)
            ->increment('posts');
    }

    /**
     * {@inheritDoc}
     */
    public function deletePost(array $ids)
    {
        $this->model
            ->whereIn('id', $ids)
            ->decrement('posts', 1);
    }

    /**
     * {@inheritDoc}
     */
    public function getTree()
    {
        return $this->model->orderBy('rank')->select('id', 'name', 'path')->get();
    }

    /**
     * {@inheritDoc}
     * 
     * @todo Order by an order field
     */
    public function getForums()
    {
        $query = $this->forumsQuery();

        return $query
            ->where('lforums.path', 'LIKE', "%")
            ->where('lforums.path', 'NOT LIKE', "%/%/%/%")
            ->orderBy('name')
            ->get();
    }

    /**
     * {@inheritDoc}
     */
    public function getSubforums($forum)
    {
        $query = $this->forumsQuery();

        return $query
            ->where('lforums.path', 'LIKE', "$forum->path%/%")
            ->where('lforums.path', 'NOT LIKE', "$forum->path%/%/%/%")
            ->get();
    }

    /**
     * The forums query shared by other queries
     *
     * @return $this
     */
    protected function forumsQuery()
    {
        $query = $this->model
            ->select('id', 'description', 'name', 'slug', 'topics_count',
                'posts', 'path')
            ->with(['topics' => function($query) {
                $query->select('title', 'last_post', 'slug', 'updated_at',
                    'forum_id', 'last_post_user')
                    ->where('deleted_at', null);
            }])
            ->orderBy('rank')
            ->groupBy('lforums.id');

        if (\Auth::check()) {
            $query->with('read');
        }

        return $query;

    }
}
