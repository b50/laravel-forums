<?php namespace Kaamaru\Forums\Topics;

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
            ->select('lforums_topics.id', 'lforums_topics.slug', 'lforums_topics.title',
                'lforums_topics.created_at', 'users.username', 'users.slug as user_slug')
            ->join('lforums_users as users', 'users.id', '=', 'user_id')
            ->take(\Config::get('forums/forum.recent'))
            ->orderBy('lforums_topics.updated_at', 'dsc')
            ->where('lforums_topics.expires_at', null)
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
            ->select('users.slug as user_slug', 'users.username', 'lforums_topics.slug', 'lforums_topics.title',
                'lforums_topics.created_at', 'lforums_topics.id', 'lforums_topics.updated_at', 'lforums_topics.views',
                'lforums_topics.posts_count', 'lforums_topics.sticky', 'lforums_topics.locked', 'lforums_topics.last_post',
                'last_user.slug as last_user_slug', 'last_user.username as last_user_username', 'lforums_topics.tag',
                'lforums_topics.path', 'first_post.votes as votes')
            ->join('lforums_users as users', 'user_id', '=', 'users.id')
            ->join('lforums_users as last_user', 'lforums_topics.last_post_user', '=', 'last_user.id')
            ->join('lforums_posts as first_post', 'lforums_topics.id', '=', 'first_post.topic_id')
            ->whereNested(function ($query) {
                /** @var $query \Illuminate\Database\Query\Builder */
                $query->where('lforums_topics.expires_at', null)
                    ->orWhere('lforums_topics.expires_at', '>', Carbon::createFromTime());
            })
            ->orderBy('lforums_topics.sticky', 'desc')
            ->orderBy($sort, $direction)
            ->groupBy('lforums_topics.id');

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
                ->select('lforums_topics.*', 'forum_topic_follow.id as following', 'forum_favorites.id as favorite');

            // Find if this topic is in our favorites
            $topic->leftJoin('forum_favorites', function ($join) use ($user) {
                $join->on('forum_favorites.topic_id', '=', 'lforums_topics.id')
                    ->where('forum_favorites.user_id', '=', $user->id);
            });

            // Find if we are following this topic
            $topic->leftJoin('forum_topic_follow', function ($join) use ($user) {
                $join->on('forum_topic_follow.topic_id', '=', 'lforums_topics.id')
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
            ->select('users.slug as user_slug', 'users.username', 'lforums_topics.slug', 'lforums_topics.title',
                'lforums_topics.created_at', 'lforums_topics.id', 'lforums_topics.updated_at', 'lforums_topics.views',
                'lforums_topics.posts_count', 'lforums_topics.sticky', 'lforums_topics.locked', 'lforums_topics.last_post',
                'last_user.slug as last_user_slug', 'last_user.username as last_user_username', 'lforums_topics.tag',
                'lforums_topics.path')
            ->join('lforums_users as users', 'user_id', '=', 'users.id')
            ->join('lforums_users as last_user', 'lforums_topics.last_post_user', '=', 'last_user.id')
            ->whereNested(function ($query) {
                /** @var $query \Illuminate\Database\Query\Builder */
                $query->where('lforums_topics.expires_at', null)
                    ->orWhere('lforums_topics.expires_at', '>', Carbon::createFromTime());
            })
            ->orderBy('lforums_topics.sticky', 'desc')
            ->orderBy($sort, $direction);

        if (\Auth::check()) {
            $topics->with('read');
        }

        return $topics;
    }
}
