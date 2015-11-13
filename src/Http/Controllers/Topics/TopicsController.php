<?php namespace LaravelForums\Http\Controllers\Topics;

use LaravelForums\Forums\Topics\TopicBuilder;
use LaravelForums\Forums\Topics\TopicRepoInterface;
use LaravelForums\Http\Controllers\BaseController;

/**
 * The topics controller
 *
 * @package App\Controllers\Forums
 */
class TopicsController extends BaseController {

	/**
	 * @param TopicRepoInterface $topic
	 * @param TopicBuilder       $topicBuilder
	 */
	public function __construct(TopicRepoInterface $topic, TopicBuilder $topicBuilder)
	{
		$this->topicRepo = $topic;
		$this->topicBuilder = $topicBuilder;
	}

	/**
	 * Show all topics
	 */
	public function getIndex()
	{
		$topics = $this->topicRepo->getAll($this->sort->getField(), $this->sort->getDirection());
		return \View::make('LaravelForums::forums.all_topics', compact('topics'), ['sort' => $this->sort]);
	}

	/**
	 * Show a topic
	 *
	 * @param string $topicType
	 * @param int    $id
	 * @return Illuminate\View\View
	 */
	public function getTopic($topicType, $id)
	{
		$topic = $this->topicBuilder->build($id);

		// Is it a suggestion topic?
		if ($topic->path and last($topic->parents)->type == 'suggestions')
		{
			return \View::make('LaravelForums::forums.suggestion_topic', compact('topic'));
		}

		return \View::make($topicType.'.topics.topic', compact('topic'));
	}

}
