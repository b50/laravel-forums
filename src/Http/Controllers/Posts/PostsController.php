<?php namespace LaravelForums\Http\Controllers\Posts;

use LaravelForums\Forums\Posts\PostRepoInterface;

/**
 * Class PostsController
 *
 * @package App\Controllers\Forums
 */
class PostsController extends BasePostsController {

	/**
	 * @param PostRepoInterface  $post
	 */
	public function __construct(PostRepoInterface $post)
	{
		$this->postRepo = $post;
		$this->post = $this->postRepo->requireById(Route::current()->parameter('id'));
	}

}
