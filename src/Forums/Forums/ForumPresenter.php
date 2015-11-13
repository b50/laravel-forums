<?php namespace LaravelForums\Forums\Forums;

use Carbon\Carbon;
use McCool\LaravelAutoPresenter\BasePresenter;

/**
 * Present the forum
 *
 * @package LaravelForums\Forums
 */
class ForumPresenter extends BasePresenter {

	/**
	 * @param EloquentForum $forum
	 */
	public function __construct(EloquentForum $forum)
	{
		$this->resource = $forum;
	}

	/**
	 * Convert to readable date
	 *
	 * @return int
	 */
	public function last_topic_updated_at()
	{
		return Carbon::createFromFormat('Y-m-d H:i:s', $this->resource->last_topic_updated_at)->diffForHumans();
	}

}
