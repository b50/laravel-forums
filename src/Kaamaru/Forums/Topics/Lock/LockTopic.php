<?php namespace Kaamaru\Forums\Topics\Lock;

use Kaamaru\Forums\Topics\TopicRepoInterface;

/**
 * Lock topic
 *
 * @package App\Forums\Topic
 */
class LockTopic
{
    /**
     * @param TopicRepoInterface $topic
     */
    public function __construct(TopicRepoInterface $topic)
    {
        $this->topicRepo = $topic;
    }

    /**
     * Lock topic
     *
     * @param LockTopicListener $listener
     * @param                   $topic
     * @return \Illuminate\Http\RedirectResponse
     */
    public function lock(LockTopicListener $listener, $topic)
    {
        $this->topicRepo->lock($topic->id);

        if ($topic->locked) {
            return $listener->topicunLocked($topic);
        }

        return $listener->topicLocked($topic);
    }
}
