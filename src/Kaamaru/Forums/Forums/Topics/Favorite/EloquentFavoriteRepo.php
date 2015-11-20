<?php namespace Kaamaru\Forums\Forums\Topics\Favorite;

use Kaamaru\Forums\Core\Repositories\EloquentRepo;

/**
 * Repo for the forum favorites
 *
 * @package App\Repositories\Forums
 */
class EloquentFavoriteRepo extends EloquentRepo implements FavoriteRepoInterface
{
    /**
     * @param EloquentFavorite $model
     */
    public function __construct(EloquentFavorite $model)
    {
        $this->model = $model;
    }

    /**
     * {@inheritDoc}
     */
    public function all($sort, $order)
    {
        return $this->model
            ->select('users.slug as user_slug', 'users.username', 'lforums_topics.slug', 'lforums_topics.title',
                'lforums_topics.created_at', 'lforums_topics.id', 'lforums_topics.updated_at',
                'lforums_topics.posts_count', 'lforums_topics.sticky', 'lforums_topics.locked',
                'last_user.slug as last_user_slug',
                'lforums_topics.deleted_at', 'last_user.username as last_user_username')
            ->where('forum_favorites.user_id', \Auth::user()->id)
            ->join('lforums_topics', 'forum_favorites.topic_id', '=', 'lforums_topics.id')
            ->join('users', 'lforums_topics.user_id', '=', 'users.id')
            ->join('users as last_user', 'lforums_topics.last_post_user', '=', 'last_user.id')
            ->orderBy('lforums_topics.sticky', 'desc')
            ->orderBy('lforums_topics.' . $sort, $order)
            ->paginate(\Config::get('forums/forum.topics_per_page'));
    }

    /**
     * {@inheritDoc}
     */
    public function add($topicId)
    {
        $this->model->insert([
            'topic_id' => $topicId,
            'user_id' => \Auth::user()->id,
        ]);
    }

    /**
     * {@inheritDoc}
     */
    public function remove($id)
    {
        $this->model
            ->where('topic_id', $id)
            ->where('user_id', \Auth::user()->id)
            ->delete();
    }

    /**
     * {@inheritDoc}
     */
    public function getByPostId($topicId, $userId)
    {
        return $this->model->where('topic_id', $topicId)->where('user_id', $userId)->first();
    }
}
