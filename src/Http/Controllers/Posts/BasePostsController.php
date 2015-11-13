<?php namespace LaravelForums\Http\Controllers\Posts;

use LaravelForums\Forums\Posts\PostRepoInterface;
use LaravelForums\Http\Controllers\BaseController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class PostsController
 *
 * @package App\Controllers\Forums
 */
abstract class BasePostsController extends BaseController {

	/**
	 * @var PostRepoInterface
	 */
	public $postRepo;

	/**
	 * A post
	 */
	public $post;

	/**
	 * Show post
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function getShow()
	{
		$page = $this->postRepo->getPostPage($this->post);

		return $this->redirectToTopic($page);
	}

	/**
	 * Redirect back to the post's topic
	 *
	 * @param null $page
	 * @return \Illuminate\Http\RedirectResponse
	 */
	protected function redirectToTopic($page = null)
	{
		// Topic not found
		if ( ! $this->post->topic)
		{
			throw new NotFoundHttpException(_('Topic could not be found.'));
		}

		$id = $this->post->topic->id;
		$slug = $this->post->topic->slug;

		if ($page)
		{
			// Redirect to the given page of the topic
			$url = URL::route('forums.topics.show', compact('id', 'slug', 'page', 'topicType')).'#post-'.$this->post->id;
			return Redirect::to($url);
		}

		// Redirect to the first page of topic
		return Redirect::route('forums.topics.show', compact('topicType', 'id', 'slug'));
	}

}
