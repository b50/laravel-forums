<?php namespace LaravelForums\Users;

use LaravelForums\Core\Repositories\EloquentRepo;

/**
 * Class EloquentUserRepo
 *
 * @package App\Repositories\Users
 */
class EloquentUserRepo extends EloquentRepo implements UserRepoInterface {

	/**
	 * Validation errors
	 */
	protected $errors;

	public $xp_amounts = [
		'tiny' => 25,
		'small' => 50,
		'medium' => 100,
		'large' => 150,
		'huge' => 200
	];

	/**
	 * @param EloquentUser $user
	 */
	public function __construct(EloquentUser $user)
	{
		$this->model = $user;
	}

	/**
	 * Get user validation errors
	 *
	 * @return array
	 */
	public function getErrors()
	{
		return $this->errors;
	}

	/**
	 * Calculate user level
	 *
	 * @return int
	 */
	public function level()
	{
		isset($this->xp) ?: $this->xp = 0;
		return floor((sqrt(100*(2*$this->xp + 25)) +50)/100);
	}

	/**
	 * Calculate progress to next level for progress bars
	 *
	 * @return int the percentage of completion to next level
	 */
	public function progress()
	{
		// Get min and max experience
		$min = $this->_calculate_xp($this->level());
		$max = $this->_calculate_xp($this->level() + 1);

		return ($this->xp - $min) / ($max - $min) * 100;
	}

	protected function _calculate_xp($level)
	{
		return (pow($level, 2)+$level)/2*100-($level*100);
	}

	/**
	 * Add experience to the user
	 *
	 * @param string $amount tiny, small etc
	 * @return void
	 */
	public function add_xp($amount)
	{
		if (isset($this->xp_amounts[$amount]))
		{
			$this->xp += $this->xp_amounts[$amount];
		}
	}

	/**
	 * {@inheritDoc}
	 */
	public function addTopic($user, $topic)
	{
		$user->topics++;
		$user->posts += $topic->posts_count;
		$user->update();
	}

	/**
	 * {@inheritDoc}
	 */
	public function addPost($userId)
	{
		return $this->model->where('id', $userId)->increment('posts');
	}

	/**
	 * {@inheritDoc}
	 */
	public function deletePost($userId)
	{
		return $this->model->where('id', $userId)->decrement('posts');
	}

	/**
	 * {@inheritDoc}
	 */
	public function deleteTopic($topic)
	{
		// Check user id is valid
		if ( ! is_int($topic->user_id))
		{
			return false;
		}

		// Build query
		$query = "UPDATE users
			      SET posts = posts - ?, topics = topics - 1
			      WHERE id = $topic->user_id";

		// Run query
		return \DB::update($query, [$topic->posts_count]);
	}

	/**
	 * Check weather a user exists by id or email
	 *
	 * @param string $id
	 * @return bool
	 */
	public function exists($id)
	{
		// See if we're using an email or username
		$field = filter_var($id, FILTER_VALIDATE_EMAIL) ? 'email' : 'id';

		return (bool) $this->model->where($field, $id)->exists();
	}

	/**
	 * {@inheritDoc}
	 */
	public function getBySlug($userSlugs)
	{
		return $this->model->whereIn('slug', $userSlugs)->get();
	}

}
