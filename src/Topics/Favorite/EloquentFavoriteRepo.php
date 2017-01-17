<?php namespace B50\Forums\Topics\Favorite;

use B50\Forums\Core\Repositories\EloquentRepo;

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
            ->where('user_id', \Auth::user()->id)
            ->orderBy('lforums_topics.sticky', 'desc')
            ->orderBy('lforums_topics.' . $sort, $order)
            ->paginate(config('forums.topics_per_page'));
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
