<?php namespace B50\Forums\Topics;

use B50\Forums\Forums\ForumRepoInterface;
use B50\Forums\Topics\Create\TopicCreator;
use Carbon\Carbon;

/**
 * Redirect topic to a different forum
 *
 * @package B50\Forums\Topics
 */
class RedirectionTopic
{
    /**
     * @param ForumRepoInterface $forum
     * @param TopicCreator $creator
     */
    public function __construct(ForumRepoInterface $forum, TopicCreator $creator)
    {
        $this->forumRepo = $forum;
        $this->topicCreator = $creator;
    }

    public function make($newForumPath, $oldTopic, $user)
    {
        $newForum = $this->forumRepo->getByPath($newForumPath);
        $oldForum = $this->forumRepo->getByPath($oldTopic->path);

        // Create post content
        $input = [
            'title' => _('Moved:') . $oldTopic->title,
            'content' => \View::make('forums.move_post', ['oldTopic' => $oldTopic, 'newForum' => $newForum])
        ];

        // Set topic attributes
        $attributes = [
            'locked' => true,
            'expires_at' => Carbon::createFromTimestamp(strtotime(\Config::get('forums/topic.move_expires')))
        ];

        // Create topic
        $this->topicCreator->create($input, $oldForum, $user, $attributes);
    }
}
