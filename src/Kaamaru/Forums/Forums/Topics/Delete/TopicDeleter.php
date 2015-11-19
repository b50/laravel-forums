<?php namespace Kaamaru\Forums\Forums\Topics\Delete;

use Kaamaru\Forums\Core\Paths\PathInterface;
use Kaamaru\Forums\Forums\Add;
use Kaamaru\Forums\Forums\Topics\TopicRepoInterface;

/**
 * I delete topics >:D
 *
 * @package App\Forums\Topic
 */
class TopicDeleter
{
    /**
     * @param TopicRepoInterface $topic
     * @param Add $add
     */
    public function __construct(TopicRepoInterface $topic, Add $add)
    {
        $this->topicRepo = $topic;
        $this->add = $add;
    }

    /**
     * Delete the topic
     *
     * @param TopicDeleteListener $listener
     * @param PathInterface $topic
     * @return TopicDeleteListener
     */
    public function delete(TopicDeleteListener $listener, PathInterface $topic)
    {
        $this->topicRepo->delete($topic->id);
        $this->add->deleteTopic($topic);

        return $listener->topicDeleted($topic);
    }
}
