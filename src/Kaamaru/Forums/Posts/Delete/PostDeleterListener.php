<?php namespace Kaamaru\Forums\Posts\Delete;

/**
 * Interface for deleted posts
 */
interface PostDeleterListener
{
    /**
     * Redirect and show message after deleting first post in a topic
     *
     * @return mixed
     */
    public function postDeleted();

    /**
     * Tell the user they can't delete the first post in a topic
     *
     * @return mixed
     */
    public function cantDeleteFirstPost();
}
