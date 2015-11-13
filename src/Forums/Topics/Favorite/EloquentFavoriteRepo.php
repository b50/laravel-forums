<?php namespace LaravelForums\Forums\Topics\Favorite;

use LaravelForums\Core\Repositories\EloquentRepo;

/**
 * Repo for the forum favorites
 *
 * @package App\Repositories\Forums
 */
class EloquentFavoriteRepo extends EloquentRepo implements FavoriteRepoInterface {

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
			->select('users.slug as user_slug', 'users.username', 'forum_topics.slug', 'forum_topics.title',
				'forum_topics.created_at', 'forum_topics.id', 'forum_topics.updated_at',
				'forum_topics.posts_count', 'forum_topics.sticky', 'forum_topics.locked', 'last_user.slug as last_user_slug',
				'forum_topics.deleted_at', 'last_user.username as last_user_username')
			->where('forum_favorites.user_id', \Auth::user()->id)
			->join('forum_topics', 'forum_favorites.topic_id', '=', 'forum_topics.id')
			->join('users', 'forum_topics.user_id', '=', 'users.id')
			->join('users as last_user', 'forum_topics.last_post_user', '=', 'last_user.id')
			->orderBy('forum_topics.sticky', 'desc')
			->orderBy('forum_topics.'.$sort, $order)
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
