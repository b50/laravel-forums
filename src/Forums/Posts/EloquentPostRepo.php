<?php namespace LaravelForums\Forums\Posts;

use LaravelForums\Core\Repositories\EloquentRepo;

/**
 * Class EloquentPostRepo
 *
 * @package App\Repositories\Forums
 */
class EloquentPostRepo extends EloquentRepo implements PostRepoInterface {

	protected $model;

	/**
	 * @param EloquentPost $post
	 */
	public function __construct(EloquentPost $post)
	{
		$this->model = $post;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getRecent()
	{
		return $this->model
			->select('forum_posts.id', 'forum_topics.title', 'forum_posts.created_at',
				'users.slug as user_slug', 'users.username as username')
			->join('users', 'users.id', '=', 'user_id')
			->join('forum_topics', 'forum_posts.topic_id', '=', 'forum_topics.id')
			->take(\Config::get('forums/forum.recent'))
			->orderBy('forum_topics.updated_at', 'dsc')
			->where('forum_topics.expires_at', null)
			->where('forum_topics.deleted_at', null)
			->get();
	}

	/**
	 * {@inheritDoc}
	 */
	public function create($input)
	{
		return $this->model->create($input);
	}

	/**
	 * {@inheritDoc}
	 */
	public function edit($postId, $data)
	{
		return $this->model->where('id', $postId)->update($data);
	}

	/**
	 * {@inheritDoc}
	 */
	public function getPostPage($post)
	{
		$position = $this->model
				->where('id', '<', $post->id)
				->where('topic_id', $post->topic_id)
				->count() + 1;
		$postsPerPage = \Config::get('forums/forum.posts_per_page');
		return ceil($position / $postsPerPage);
	}

	/**
	 * {@inheritDoc}
	 */
	public function delete($id)
	{
		$this->model->where('id', $id)->delete();
	}

	/**
	 * {@inheritDoc}
	 */
	public function getEmptyPost()
	{
		return $this->model;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getFirstPostId($topicId)
	{
		return $this->model->where('topic_id', $topicId)->orderBy('id')->first(['id'])->id;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getLastPost($topicId)
	{
		return $this->model->where('topic_id', $topicId)->orderBy('id', 'desc')->first();
	}

	/**
	 * {@inheritDoc}
	 */
	public function incrementVote($postId)
	{
		$this->model->where('id', $postId)->increment('votes');
	}

	/**
	 * {@inheritDoc}
	 */
	public function decrementVote($postId)
	{
		$this->model->where('id', $postId)->decrement('votes');
	}

	/**
	 * Find out if a post is the first post in the topic
	 *
	 * @param $post
	 * @return bool
	 */
	public function isFirst($post)
	{
		return $post->id == $this->model->orderBy('id')->where('topic_id', $post->topic_id)->first()->id;
	}
}
