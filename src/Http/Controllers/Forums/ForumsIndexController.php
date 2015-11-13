<?php namespace LaravelForums\Http\Controllers\Forums;

use LaravelForums\Forums\Forums\ForumRepoInterface;
use LaravelForums\Forums\Posts\PostRepoInterface;
use LaravelForums\Forums\Topics\TopicRepoInterface;
use LaravelForums\Http\Controllers\BaseController;

/**
 * The forums index controller
 */
class ForumsIndexController extends BaseController {

	/**
	 * @param TopicRepoInterface     $topic
	 * @param PostRepoInterface      $post
	 * @param ForumRepoInterface     $forum
	 */
	public function __construct(TopicRepoInterface $topic, PostRepoInterface $post, ForumRepoInterface $forum)
	{
		$this->topicRepo = $topic;
		$this->postRepo = $post;
		$this->forumRepo = $forum;
	}

	/**
	 * Forums index
	 *
	 * @return \Illuminate\View\View
	 */
	public function getIndex()
	{
		$forums = $this->forumRepo->getForums();

		// Get sidebar info
		$recentPosts = $this->postRepo->getRecent();
		$recentTopics = $this->topicRepo->getRecent();

		return \View::make('LaravelForums::forums.forums', compact('forums', 'recentTopics', 'recentPosts'));
	}

}
