<?php namespace LaravelForums\Forums\Topics\Move;

use LaravelForums\Core\Paths\PathInterface;
use LaravelForums\Forums\Forums\ForumRepoInterface;
use LaravelForums\Forums\Topics\TopicRepoInterface;

/**
 * Move a topic
 *
 * @package App\Forums\TopicMoveService
 */
class TopicMover {

	/**
	 * @param TopicRepoInterface $topic
	 * @param ForumRepoInterface $forum
	 */
	public function __construct(TopicRepoInterface $topic, ForumRepoInterface $forum)
	{
		$this->topicRepo = $topic;
		$this->forumRepo = $forum;
	}

	/**
	 * Does not update last post. Too many queries!
	 *
	 * @param PathInterface $topic
	 * @param array         $input
	 * @return void
	 */
	public function move(PathInterface $topic, array $input)
	{
		// Move topic
		$this->topicRepo->move($topic->id, $input['forum']);

		// Update forum post and topic counts
		$this->forumRepo->deleteTopic($topic);
		$this->forumRepo->addTopic(explode('/', $input['forum']), $topic);
	}

}
