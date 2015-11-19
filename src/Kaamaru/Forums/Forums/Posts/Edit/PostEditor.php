<?php namespace Kaamaru\Forums\Forums\Posts\Edit;

use Kaamaru\Forums\Forums\Posts\PostRepoInterface;

/**
 * Class PostEditor
 *
 * @package Kaamaru\Forums\Forums\Posts\Edit
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
