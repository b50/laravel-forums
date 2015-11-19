<?php namespace Kaamaru\Forums\Forums\Topics\Create;

use Kaamaru\Forums\Forums\Add;
use Kaamaru\Forums\Forums\Forums\Read\ForumReadRepoInterface;
use Kaamaru\Forums\Forums\Posts\Create\PostCreator;
use Kaamaru\Forums\Forums\Topics\TopicRepoInterface;

/**
 * Class TopicCreator
 *
 * @package App\Forums\Topic
 */
class TopicCreator
{
    /**
     * @param PostCreator $creator
     * @param Add $add
     * @param TopicRepoInterface $topic
     * @param ForumReadRepoInterface $read
     */
    public function __construct(PostCreator $creator, Add $add, TopicRepoInterface $topic, ForumReadRepoInterface $read)
    {
        $this->postCreator = $creator;
        $this->add = $add;
        $this->topicRepo = $topic;
        $this->read = $read;
    }

    /**
     * Create topic
     *
     * @param $input
     * @param $user
     * @return
     */
    public function create($input, $user)
    {
        // Create topic
        $topic = $this->topicRepo->create($user->id, $input);

        // Create post's topic
        $post = $this->postCreator->create($input, $topic, $user, false);

        // Add post to topic
        $this->add->addPostToTopic($topic, $post);

        // Add topic to forums and user
        $this->add->addTopic($topic->pathExplode(), $topic, $user);

        // Clear read for forum's topic belongs to
        if ($topic->path) {
            $this->read->clearRead($topic->pathExplode());
        }

        return $topic;
    }
}
