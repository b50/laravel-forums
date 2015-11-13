<?php namespace LaravelForums\Http\Controllers\Forums;

use LaravelForums\Forums\Forums\ForumRepoInterface;
use LaravelForums\Forums\Forums\ForumTree;
use LaravelForums\Forums\Topics\Create\CreateTopicRequest;
use LaravelForums\Forums\Topics\Create\TopicCreateListener;
use LaravelForums\Http\Controllers\BaseController;

/**
 * The forums controller
 */
class NewTopicForumsController extends BaseController implements TopicCreateListener {

	/**
	 * @var Object The forum
	 */
	protected $forum;

	/**
	 * @param ForumRepoInterface $forum
	 * @param ForumTree          $tree
	 * @param CreateTopicRequest $request
	 */
	public function __construct(ForumRepoInterface $forum, ForumTree $tree, CreateTopicRequest $request)
	{
		$this->forumRepo = $forum;
		$this->tree = $tree;
		$this->createRequest = $request;
	}

	/**
	 * Show new topic page
	 *
	 * @param int $id
	 * @return \Illuminate\View\View
	 */
	public function getNewTopic($id)
	{
		$forum = $this->forumRepo->requireById($id);
		$forums = $this->tree->getTree();
		return \View::make('LaravelForums::forums.new_topic', compact('forum', 'forums'));
	}

	/**
	 * Create a new topic
	 *
	 * @param int $id
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
	 */
	public function postNewTopic($id)
	{
		$this->forum = $this->forumRepo->requireById($id);
		return $this->createRequest->create($this, \Input::all(), \Auth::user());
	}

	/**
	 * {@inheritDoc}
	 */
	public function showPreview($post, $topic)
	{
		return \View::make('LaravelForums::forums.new_topic_preview', compact('post', 'topic'), ['forum' => $this->forum]);
	}

	/**
	 * {@inheritDoc}
	 */
	public function TopicCreated($topic)
	{
		return \Redirect::route('forums.topics.show', [
				'topicType' => 'forums',
				'id' => $topic->id,
				'slug' => $topic->slug
			]);
	}

	/**
	 * {@inheritDoc}
	 */
	public function topicCreationFailed($errors)
	{
		return \Redirect::route('forums.topics.new', ['id' => $this->forum->id, 'slug' => $this->forum->slug])
			->withInput()->withErrors($errors);
	}

	/**
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function backFromPreview()
	{
		return \Redirect::route('forums.topics.new', ['id' => $this->forum->id, 'slug' => $this->forum->slug])
			->withInput();
	}
}
