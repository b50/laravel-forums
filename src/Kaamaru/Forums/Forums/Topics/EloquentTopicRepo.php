<?php namespace Kaamaru\Forums\Forums\Topics;

use Kaamaru\Forums\Core\Repositories\EloquentRepo;
use Carbon\Carbon;

/**
 * Repo for EloquentTopic
 *
 * @package App\Repositories\Forums
 */
class EloquentTopicRepo extends EloquentRepo implements TopicRepoInterface
{
    /**
     * @param EloquentTopic $topic
     */
    public function __construct(EloquentTopic $topic)
    {
        $this->model = $topic;
    }

    /**
     * {@inheritDoc}
     */
    public function getRecent()
    {
        return $this->model
            ->select('forum_topics.id', 'forum_topics.slug', 'forum_topics.title', 'forum_topics.created_at',
                'users.username', 'users.slug as user_slug')
            ->join('users', 'users.id', '=', 'user_id')
            ->take(\Config::get('forums/forum.recent'))
            ->orderBy('forum_topics.updated_at', 'dsc')
            ->where('forum_topics.expires_at', null)
            ->get();
    }

    /**
     * {@inheritDoc}
     */
    public function getAll($sort, $order)
    {
        // Get topics
        return $this
            ->getTopicsQuery($sort, $order)
            ->paginate(\Config::get('forums/forum.topics_per_page'));
    }

    /**
     * {@inheritDoc}
     */
    public function getForForum($forumPath, $sort, $direction)
    {
        return $this
            ->getTopicsQuery($sort, $direction)
            ->where('path', $forumPath)
            ->paginate(\Config::get('forums/forum.topics_per_page'));
    }

    public function getForSuggestionForum($forumPath, $sort, $direction)
    {
        $topics = $this->model
            ->select('users.slug as user_slug', 'users.username', 'forum_topics.slug', 'forum_topics.title',
                'forum_topics.created_at', 'forum_topics.id', 'forum_topics.updated_at', 'forum_topics.views',
                'forum_topics.posts_count', 'forum_topics.sticky', 'forum_topics.locked', 'forum_topics.last_post',
                'last_user.slug as last_user_slug', 'last_user.username as last_user_username', 'forum_topics.tag',
                'forum_topics.path', 'first_post.votes as votes')
            ->join('users', 'user_id', '=', 'users.id')
            ->join('users as last_user', 'forum_topics.last_post_user', '=', 'last_user.id')
            ->join('forum_posts as first_post', 'forum_topics.id', '=', 'first_post.topic_id')
            ->whereNested(function ($query) {
                /** @var $query \Illuminate\Database\Query\Builder */
                $query->where('forum_topics.expires_at', null)
                    ->orWhere('forum_topics.expires_at', '>', Carbon::createFromTime());
            })
            ->orderBy('forum_topics.sticky', 'desc')
            ->orderBy($sort, $direction)
            ->groupBy('id');

        if (\Auth::check()) {
            $topics->with('read');
        }

        return $topics->where('path', $forumPath)
            ->paginate(\Config::get('forums/forum.topics_per_page'));
    }

    /**
     * {@inheritDoc}
     */
    public function getForTopicPage($id, $user)
    {
        // Get EloquentTopic
        $topic = $this->model;

        // Get user specific stuff if user is logged in
        if ($user) {
            $topic = $topic
                ->select('forum_topics.*', 'forum_topic_follow.id as following', 'forum_favorites.id as favorite');

            // Find if this topic is in our favorites
            $topic->leftJoin('forum_favorites', function ($join) use ($user) {
                $join->on('forum_favorites.topic_id', '=', 'forum_topics.id')
                    ->where('forum_favorites.user_id', '=', $user->id);
            });

            // Find if we are following this topic
            $topic->leftJoin('forum_topic_follow', function ($join) use ($user) {
                $join->on('forum_topic_follow.topic_id', '=', 'forum_topics.id')
                    ->where('forum_topic_follow.user_id', '=', $user->id);
            });
        }

        // Return topic
        return $this->makeRequired($topic->find($id));
    }

    /**
     * {@inheritDoc}
     */
    public function delete($id)
    {
        $this->model
            ->where('id', $id)
            ->delete();
    }

    /**
     * {@inheritDoc}
     */
    public function create($userId, $attributes = [])
    {
        return $this->model->create([
            'user_id' => $userId,
            'created_at' => date('Y-m-d H:i:s'),
            'title' => $attributes['title'],
            'slug' => \Str::slug($attributes['title']) ?: 'topic',
            'path' => isset($attributes['path']) ? $attributes['path'] : null,
        ]);
    }

    /**
     * {@inheritDoc}
     */
    public function addPost($topic, $post)
    {
        $topic->updated_at = time();
        $topic->last_post_user = $post->user_id;
        $topic->last_post = $post->id;
        $topic->posts_count++;
        return $topic->save();
    }

    /**
     * {@inheritDoc}
     */
    public function sticky($id)
    {
        return $this->model->where('id', $id)->update(['sticky' => \DB::raw('NOT sticky')]);
    }

    /**
     * {@inheritDoc}
     */
    public function lock($id)
    {
        return $this->model->where('id', $id)->update(['locked' => \DB::raw('NOT locked')]);
    }

    /**
     * {@inheritDoc}
     */
    public function getEmptyTopic()
    {
        return $this->model;
    }

    /**
     * {@inheritDoc}
     */
    public function getAncestors($id)
    {
        $topic = $this->model->select('ancestors')->find($id);
        return $topic->ancestors;
    }

    /**
     * {@inheritDoc}
     */
    public function move($topicId, $forumPath)
    {
        return $this->model
            ->where('id', $topicId)
            ->update(['path' => $forumPath]);
    }

    /**
     * {@inheritDoc}
     */
    public function deletePost($topicId, $lastPost = null)
    {
        if ($lastPost) {
            return $this->model
                ->where('id', $topicId)
                ->decrement('posts_count', 1, [
                    'last_post' => $lastPost->id,
                    'last_post_user' => $lastPost->user_id,
                ]);
        }

        return $this->model
            ->where('id', $topicId)
            ->decrement('posts_count');
    }

    /**
     * {@inheritDoc}
     */
    public function updateTopic($topicId, $data)
    {
        $this->model->where('id', $topicId)->update($data);
    }

    /**
     * {@inheritDoc}
     */
    protected function getTopicsQuery($sort, $direction)
    {
        // Get topics
        $topics = $this->model
            ->select('users.slug as user_slug', 'users.username', 'forum_topics.slug', 'forum_topics.title',
                'forum_topics.created_at', 'forum_topics.id', 'forum_topics.updated_at', 'forum_topics.views',
                'forum_topics.posts_count', 'forum_topics.sticky', 'forum_topics.locked', 'forum_topics.last_post',
                'last_user.slug as last_user_slug', 'last_user.username as last_user_username', 'forum_topics.tag',
                'forum_topics.path')
            ->join('users', 'user_id', '=', 'users.id')
            ->join('users as last_user', 'forum_topics.last_post_user', '=', 'last_user.id')
            ->whereNested(function ($query) {
                /** @var $query \Illuminate\Database\Query\Builder */
                $query->where('forum_topics.expires_at', null)
                    ->orWhere('forum_topics.expires_at', '>', Carbon::createFromTime());
            })
            ->orderBy('forum_topics.sticky', 'desc')
            ->orderBy($sort, $direction);

        if (\Auth::check()) {
            $topics->with('read');
        }

        return $topics;
    }
}
