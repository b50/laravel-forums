<?php namespace B50\Forums\Topics\Read;

interface TopicReadRepoInterface
{
    /**
     * Mark the topic as read
     *
     * @param int $topicId
     * @param int $userId
     * @return void
     */
    public function markAsRead($topicId, $userId);

    /**
     * Clear the topic of read markers
     *
     * @param array $topicId
     * @param int|null $userId
     * @return void
     */
    public function clearRead($topicId, $userId = null);
}
