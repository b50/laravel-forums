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
			      SET post_count = post_count + ?, topic_count = topic_count + 1, last_topic = ?
			      WHERE id IN ($ids)";

            \DB::update($query, [$topic->post_count, $topic->id]);
        } else {
            $query = "UPDATE forums
			      SET post_count = post_count + ?, topic_count = topic_count + 1
			      WHERE id IN ($ids)";

            \DB::update($query, [$topic->post_count]);
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
			      SET post_count = post_count - ?, topic_count = topic_count - 1
			      WHERE id IN ($ids)";

        return \DB::update($query, [$topic->post_count]);
    }

    /**
     * {@inheritDoc}
     */
    public function addPost(array $ids, $post)
    {
        $this->model
            ->whereIn('id', $ids)
            ->increment('post_count');
    }

    /**
     * {@inheritDoc}
     */
    public function deletePost(array $ids)
    {
        $this->model
            ->whereIn('id', $ids)
            ->decrement('post_count', 1);
    }

    /**
     * {@inheritDoc}
     */
    public function getTree()
    {
        return $this->model
            ->select('id', 'name', 'path')
            ->orderBy('rank')
            ->get();
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
            ->orderBy('name')
            ->get();
    }

    /**
     * {@inheritDoc}
     */
    public function getSubforums($forum)
    {
        $query = $this->forumsQuery();

        $path = $forum->path ? "$forum->path/$forum->id" : $forum->id;
        return $query
            ->where('path', '=', $path)
            ->orwhere('path', 'LIKE', "$forum->path/$forum->id/%")
            ->get();
    }

    /**
     * The forums query shared by other queries
     *
     * @return \Eloquent
     */
    protected function forumsQuery()
    {
        $query = $this->model
            ->with(['topics' => function($query) {
                $query->select('title', 'last_post_id', 'slug', 'updated_at',
                    'forum_id', 'last_post_user_id')
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
