<?php namespace Kaamaru\Forums\Forums\Forums\Read;

interface ForumReadRepoInterface
{
    /**
     * Mark the forum as read
     *
     * @param int $forumId
     * @param int $userId
     * @return void
     */
    public function markAsRead($forumId, $userId);

    /**
     * Clear the forum of read markers
     *
     * @param array $forumIds
     * @param int|null $userId
     * @return void
     */
    public function clearRead(array $forumIds, $userId = null);
}
