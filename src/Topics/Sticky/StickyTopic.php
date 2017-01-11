<?php namespace Kaamaru\Forums\Topics\Sticky;

use Kaamaru\Forums\Topics\TopicRepoInterface;

/**
 * Make a topic sticky
 *
 * @package App\Forums\Topic
 */
class StickyTopic
{
    /**
     * @param TopicRepoInterface $topic
     */
    public function __construct(TopicRepoInterface $topic)
    {
        $this->topicRepo = $topic;
    }

    /**
     * @param $listener
     * @param $topic
     * @return mixed
     */
    public function sticky(StickyTopicListener $listener, $topic)
    {
        $this->topicRepo->sticky($topic->id);

        if ($topic->sticky) {
            return $listener->topicUnstickied($topic);
        }

        return $listener->topicStickied($topic);
    }
}
