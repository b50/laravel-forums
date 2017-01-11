<?php namespace B50\Forums\Posts\Edit;

use B50\Forums\Posts\PostRepoInterface;

/**
 * Class PostEditor
 *
 * @package B50\Forums\Posts\Edit
 */
class PostEditor
{
    /**
     * @param PostRepoInterface $post
     */
    public function __construct(PostRepoInterface $post)
    {
        $this->postRepo = $post;
    }

    /**
     * @param $postId
     * @param $input
     */
    public function edit($postId, $input)
    {
        // Edit post
        $this->postRepo->edit($postId, [
            'markdown' => $input['content'],
            'html' => \Purifier::clean(\Markdown::text($input['content']))
        ]);
    }
}
