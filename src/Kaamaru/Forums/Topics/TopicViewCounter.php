<?php namespace Kaamaru\Forums\Topics;

/**
 * Track topic views. 
 * This function increments the view count for every new user or ip adress 
 * or user.
 * A user can update the vote count again after 5 minutes.
 *
 * @package Kaamaru\Forums\Topics
 */
class TopicViewCounter
{
    /**
     * @param TopicRepoInterface $topic
     */
    public function __construct(TopicRepoInterface $topic)
    {
        $this->topicRepo = $topic;
    }

    /**
     * Increment views
     *
     * @param $topicId
     */
    public function increment($topicId)
    {
        // Track user by id and guest by ip
        $key = (\Auth::check())
            ? 'lforums:topic-views:user_' . \Auth::user()->id
            : 'lforums:topic-views:ip_' . \Request::getClientIp();

        $key .= $topicId;

        // Increment topic views
        if ( ! \Cache::get($key)) {
            $this->topicRepo->increment('lforums.topics', $topicId, 'views');
        }

        // Store view for 5 minutes
        \Cache::put($key, 1, 5*60);

    }
}
