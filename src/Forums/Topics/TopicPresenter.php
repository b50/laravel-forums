<?php namespace LaravelForums\Forums\Topics;

use Carbon\Carbon;
use McCool\LaravelAutoPresenter\BasePresenter;

/**
 * Present the topic
 *
 * @package LaravelForums\Forums
 */
class TopicPresenter extends BasePresenter {

	/**
	 * @param EloquentTopic $topic
	 */
	public function __construct(EloquentTopic $topic)
	{
		$this->resource = $topic;
	}

	/**
	 * Convert to readable date
	 *
	 * @return int
	 */
	public function updated_at()
	{
		return Carbon::createFromFormat('Y-m-d H:i:s', $this->resource->updated_at)->diffForHumans();
	}

	/**
	 * Convert to readable date
	 *
	 * @return int
	 */
	public function created_at()
	{
		return Carbon::createFromFormat('Y-m-d H:i:s', $this->resource->created_at)->diffForHumans();
	}

	public function vote()
	{
		if ($this->resource->vote > 0)
		{
			return '<span class="success">'.$this->resource->vote.'</span>';
		}
		elseif ($this->resource->vote < 0)
		{
			return '<span class="danger">'.$this->resource->vote.'</span>';
		}

		return null;
	}

	public function tag()
	{
		// Green tags
		if (in_array($this->resource->tag, \Config::get('forums/topic.tags.green')))
		{
			return '<span class="label label-green">'.$this->resource->tag.'</span>';
		}

		// Grey tags
		if (in_array($this->resource->tag, \Config::get('forums/topic.tags.grey')))
		{
			return '<span class="label label-gray">'.$this->resource->tag.'</span>';
		}

		// Red tags
		if (in_array($this->resource->tag, \Config::get('forums/topic.tags.red')))
		{
			return '<span class="label label-red">'.$this->resource->tag.'</span>';
		}

		// Orange tags
		if (in_array($this->resource->tag, \Config::get('forums/topic.tags.orange')))
		{
			return '<span class="label label-orange">'.$this->resource->tag.'</span>';
		}

		// Custom tags
		if (count($tag = explode('::', $this->resource->tag)) == 2)
		{
			return '<span class="label" style="background-color:'.$tag[0].'">'.$tag[1].'</span>';
		}
	}

}
