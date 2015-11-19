<?php namespace Kaamaru\Forums\Forums\Forums;

use Kaamaru\Forums\Core\Repositories\EloquentRepo;
use Kaamaru\Forums\Forums\Topics\EloquentTopic;

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
     */
    public function getForums()
    {
        $query = $this->forumsQuery();

        return $query
            ->where('forums.path', 'LIKE', "%")
            ->where('forums.path', 'NOT LIKE', "%/%/%/%")
            ->get();
    }

    /**
     * {@inheritDoc}
     */
    public function getSubforums($forum)
    {
        $query = $this->forumsQuery();

        return $query
            ->where('forums.path', 'LIKE', "$forum->path%/%")
            ->where('forums.path', 'NOT LIKE', "$forum->path%/%/%/%")
            ->get();
    }

    /**
     * The forum query
     *
     * @return $this
     */
    protected function forumsQuery()
    {
        $query = $this->model
            ->select('forums.id', 'forums.description', 'forums.name', 'forums.slug', 'forums.topics_count',
                'forums.posts', 'forums.path', 'last_topic.updated_at as last_topic_updated_at',
                'last_topic.slug as last_topic_slug', 'last_topic.last_post as last_post',
                'last_topic.title as last_topic_title', 'last_user.slug as last_user_slug',
                'last_user.username as last_user_username')
            ->leftJoin(
                \DB::raw('(' . \DB::table('forum_topics')
                        ->select('title', 'last_post', 'slug', 'updated_at', 'path', 'last_post_user')
                        ->where('deleted_at', null)
                        ->orderBy('updated_at', 'desc')
                        ->toSql() . ' ) last_topic'), function ($join) {
                // Mysql connects using the concat function
                if (\DB::getDriverName() == 'mysql') {
                    $join->on('last_topic.path', 'like', \DB::raw("CONCAT(forums.path, '%')"));
                } // Else probably use || or at least that is how sqlite does it.
                else {
                    $join->on('last_topic.path', 'like', "path || '%'");
                }
            })
            ->leftjoin('users as last_user', 'last_topic.last_post_user', '=', 'last_user.id')
            ->orderBy('rank')
            ->groupBy('forums.id');

        if (\Auth::check()) {
            $query->with('read');
        }

        return $query;

    }
}
