<?php namespace Kaamaru\Forums\Forums\Topics;

/**
 * Track topic views
 *
 * @package Kaamaru\Forums\Forums\Topics
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
            ? 'laravel:topic-views:user_' . \Auth::user()->id
            : 'laravel:topic-views:ip_' . \Request::getClientIp();

        // Increment topic views
        if (!\Redis::lrem($key, 1, $topicId)) {
            $this->topicRepo->increment($topicId, 'views');
        }

        // Add topic to redis so that we cant view topic twice
        \Redis::lPush($key, $topicId);

        // Set list expire time back to to 5 minutes
        \Redis::expire($key, 5 * 60);

        // Limit number of topics in list to 20
        \Redis::lTrim($key, 0, 19);
    }
}
