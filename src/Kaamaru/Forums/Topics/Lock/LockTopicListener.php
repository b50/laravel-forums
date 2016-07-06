<?php namespace Kaamaru\Forums\Topics\Lock;

/**
 * Interface TopicMoverInterface
 *
 * @package App\Forums
 */
interface LockTopicListener
{
    /**
     * The topic has been deleted
     *
     * @param $topic
     * @return \Illuminate\Http\RedirectResponse
     */
    public function topicLocked($topic);

    /**
     * The topic has been deleted
     *
     * @param $topic
     * @return \Illuminate\Http\RedirectResponse
     */
    public function topicUnlocked($topic);
}
