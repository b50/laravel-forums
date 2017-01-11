<?php namespace B50\Forums\Posts;

/**
 * Generate links
 *
 * @package App\Composers\Forums
 */
class MovePostComposer
{
    /**
     * @param $view
     */
    public function compose($view)
    {
        $view->oldTopicURL = \URL::route('forums.topics.show',
            ['id' => $view->oldTopic->id, 'slug' => $view->oldTopic->slug]);

        $view->newForumURL = \URL::route('forums.show',
            ['id' => $view->newForum->id, 'slug' => $view->newForum->slug]);
    }
}
