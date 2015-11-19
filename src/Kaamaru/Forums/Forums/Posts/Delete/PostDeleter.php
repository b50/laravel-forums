<?php namespace Kaamaru\Forums\Forums\Posts\Delete;

use Kaamaru\Forums\Forums\Add;
use Kaamaru\Forums\Forums\Posts\EloquentPostRepo;

/**
 * I delete posts >:D
 *
 * @package Kaamaru\Forums\Forums\Posts
 */
class PostDeleter
{
    /**
     * @param EloquentPostRepo $post
     * @param Add $add
     */
    public function __construct(EloquentPostRepo $post, Add $add)
    {
        $this->postRepo = $post;
        $this->add = $add;
    }

    /**
     * Delete a post
     *
     * @param PostDeleterListener $listener
     * @param                      $input
     * @param                      $post
     * @return mixed
     */
    public function delete(PostDeleterListener $listener, $input, $post)
    {
        // Check can delete
        if ($this->postRepo->getFirstPostId($post->topic->id) == $post->id) {
            return $listener->cantDeleteFirstPost();
        }

        // Delete post
        $this->postRepo->delete($post->id);

        // Update post counts
        $this->add->deletePost($post);

        return $listener->postDeleted();
    }
}
