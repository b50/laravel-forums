<?php namespace LaravelForums\Http\Controllers\Posts;

use LaravelForums\Forums\Posts\PostRepoInterface;
use LaravelForums\Forums\Posts\Report\PostReporter;

/**
 * Class PostsController
 *
 * @package App\Controllers\Forums
 */
class ReportPostsController extends BasePostsController {

	/**
	 * @param PostRepoInterface $post
	 * @param PostReporter      $reporter
	 */
	public function __construct(PostRepoInterface $post, PostReporter $reporter)
	{
		$this->postRepo = $post;
		$this->post = $this->postRepo->requireById(Route::current()->parameter('id'));
		$this->reporter = $reporter;
	}

	/**
	 * Show report page
	 *
	 * @return \Illuminate\View\View
	 */
	public function getReport($topicType)
	{
		return View::make($topicType.'.posts.report', ['post' => $this->post]);
	}

	/**
	 * Report post
	 *
	 * @return mixed
	 */
	public function postReport()
	{
		if ($this->post->user_id == \Auth::user()->id)
		{
			\Flash::danger("Why would you report your own post?!", 'post-'.$this->post->id);
		}
		elseif ($this->reporter->report($this->post->id, \Auth::user()->id))
		{
			\Flash::success('Thanks for reporting a post. Somebody with power will look at it soon ^_^.',
				'post-'.$this->post->id);
		}
		else
		{
			\Flash::danger("You've already reported this post.", 'post-'.$this->post->id);
		}

		return $this->getShow();
	}

}
