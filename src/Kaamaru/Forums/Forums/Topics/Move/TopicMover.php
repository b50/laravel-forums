<?php namespace Kaamaru\Forums\Forums\Topics\Move;

use Kaamaru\Forums\Core\Paths\PathInterface;
use Kaamaru\Forums\Forums\Forums\ForumRepoInterface;
use Kaamaru\Forums\Forums\Topics\TopicRepoInterface;

/**
 * Move a topic
 *
 * @package App\Forums\TopicMoveService
 */
class TopicMover
{
    /**
     * @param TopicRepoInterface $topic
     * @param ForumRepoInterface $forum
     */
    public function __construct(TopicRepoInterface $topic, ForumRepoInterface $forum)
    {
        $this->topicRepo = $topic;
        $this->forumRepo = $forum;
    }

    /**
     * Does not update last post. Too many queries!
     *
     * @param PathInterface $topic
     * @param array $input
     * @return void
     */
    public function move(PathInterface $topic, array $input)
    {
        // Move topic
        $this->topicRepo->move($topic->id, $input['forum']);

        // Update forum post and topic counts
        $this->forumRepo->deleteTopic($topic);
        $this->forumRepo->addTopic(explode('/', $input['forum']), $topic);
    }
}