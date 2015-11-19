<?php namespace Kaamaru\Forums\Http\Controllers\Posts;

use Kaamaru\Forums\Forums\Posts\PostRepoInterface;

/**
 * Class PostsController
 *
 * @package App\Controllers\Forums
 */
class PostsController extends BasePostsController
{
    /**
     * @param PostRepoInterface $post
     */
    public function __construct(PostRepoInterface $post)
    {
        $this->postRepo = $post;
        $this->post = $this->postRepo->requireById(Route::current()->parameter('id'));
    }
}
