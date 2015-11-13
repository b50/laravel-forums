<?php namespace LaravelForums\Http\Controllers\Forums;

use LaravelForums\Forums\Forums\ForumRepoInterface;
use LaravelForums\Forums\Forums\Read\ForumReadRepoInterface;
use LaravelForums\Forums\Topics\TopicRepoInterface;
use LaravelForums\Forums\Topics\TopicSort;
use LaravelForums\Http\Controllers\BaseController;

/**
 * The forums controller
 */
class ForumsController extends BaseController {

	/**
	 * @param ForumRepoInterface     $forum
	 * @param ForumReadRepoInterface $read
	 * @param TopicSort              $topicSort
	 * @param TopicRepoInterface     $topic
	 */
	public function __construct(ForumRepoInterface $forum, ForumReadRepoInterface $read, TopicSort $topicSort,
		TopicRepoInterface $topic)
	{
		$this->forumRepo = $forum;
		$this->readRepo =  $read;
		$this->topicSort = $topicSort;
		$this->topicRepo = $topic;
	}

	/**
	 * Get a forum by it's id
	 *
	 * @param int $id
	 * @return \Illuminate\View\View
	 */
	public function getForum($id)
	{
		// Get forums
		$forum = $this->forumRepo->requireById($id);
		$subforums = $this->forumRepo->getSubforums($forum);

		// Mark forum as read
		if (\Auth::check())
		{
			$this->readRepo->markAsRead($forum->id, \Auth::user()->id);
		}

		if ($forum->type == 'suggestions')
		{
			// Get topics and order by vote
			$this->topicSort->setDefaultField('first_post.votes');
			$topics = $this->topicRepo->getForSuggestionForum($forum->path, $this->topicSort->getField(),
				$this->topicSort->getDirection());

			return \View::make('LaravelForums::forums.suggestion', compact('forum', 'subforums', 'topics'),
				['sort' => $this->topicSort]);
		}

		// Get topics
		$topics = $this->topicRepo->getForForum($forum->path, $this->topicSort->getField(),
			$this->topicSort->getDirection());

		return View::make('LaravelForums::forums.forum', compact('forum', 'subforums', 'topics'), ['sort' => $this->topicSort]);
	}

}
