<?php namespace B50\Forums\Topics;

use B50\Forums\Core\Repositories\EloquentRepo;
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
            ->select('id', 'slug', 'title', 'created_at', 'author_id')
            ->with('author')
            ->take(\Config::get('forums/forum.recent'))
            ->orderBy('updated_at', 'dsc')
            ->where('expires_at', null)
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
            ->paginate(config('forums.topics_per_page'));
    }

    /**
     * {@inheritDoc}
     */
    public function getForForum($forumId, $sort, $direction)
    {
        return $this
            ->getTopicsQuery($sort, $direction)
            ->where('forum_id', $forumId)
            ->paginate(config('forums.topics_per_page'));
    }

    public function getForSuggestionForum($forumId, $sort, $direction)
    {
        $topics = $this->model
            ->select('slug', 'title', 'created_at', 'id', 'updated_at', 'views',
                'posts_count', 'sticky', 'locked', 'last_post', 'forum_id')
            ->orderBy('sticky', 'desc')
            ->orderBy($sort, $direction)
            ->groupBy('id');

        if (\Auth::check()) {
            $topics->with('read');
        }

        return $topics->where('forum_id', $forumId)
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
                ->select('*', 'forum_topic_follow.id as following', 'forum_favorites.id as favorite');

            // Find if this topic is in our favorites
            $topic->leftJoin('forum_favorites', function ($join) use ($user) {
                $join->on('forum_favorites.topic_id', '=', 'id')
                    ->where('forum_favorites.user_id', '=', $user->id);
            });

            // Find if we are following this topic
            $topic->leftJoin('forum_topic_follow', function ($join) use ($user) {
                $join->on('forum_topic_follow.topic_id', '=', 'id')
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
            'forum_id' => isset($attributes['forum_id']) ?
                $attributes['forum_id'] : null,
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
    public function move($topicId, $forumId)
    {
        return $this->model
            ->where('id', $topicId)
            ->update(['forum_id' => $forumId]);
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
            ->select('slug', 'title', 'created_at', 'id', 'updated_at', 'views',
                'posts_count', 'sticky', 'locked', 'last_post','tag',
                'forum_id')
            ->whereNested(function ($query) {
                /** @var $query \Illuminate\Database\Query\Builder */
                $query->where('expires_at', null)
                    ->orWhere('expires_at', '>', Carbon::createFromTime());
            })
            ->orderBy('sticky', 'desc')
            ->orderBy($sort, $direction);

        if (\Auth::check()) {
            $topics->with('read');
        }

        return $topics;
    }
}
