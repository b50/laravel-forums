<?php namespace Kaamaru\Forums\Forums\Topics\Delete;

/**
 * Interface TopicMoverInterface
 *
 * @package App\Forums
 */
interface TopicDeleteListener
{
    /**
     * The topic has been deleted
     *
     * @return mixed
     */
    public function topicDeleted($topic);
}
