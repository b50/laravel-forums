<?php namespace B50\Forums\Http\Controllers\Posts;

use B50\Forums\Posts\PostRepoInterface;

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
        $this->post = $this->postRepo->requireById(\Route::input('id'));
    }
}
