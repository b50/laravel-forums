<?php namespace B50\Forums\Read;

use B50\Forums\Core\Repositories\EloquentRepo;

class EloquentForumReadRepo extends EloquentRepo implements ForumReadRepoInterface
{
    public function __construct(EloquentForumRead $read)
    {
        $this->model = $read;
    }

    /**
     * {@inheritDoc}
     */
    public function markAsRead($forumId, $userId)
    {
        if (!$this->model->where('forum_id', $forumId)->where('user_id', $userId)->first()) {
            $this->model->insert([
                'forum_id' => $forumId,
                'user_id' => $userId,
            ]);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function clearRead(array $forumIds, $userId = null)
    {
        if ($userId) {
            $this->model->whereIn('forum_id', $forumIds)->where('user_id', $userId)->delete();
        } else {
            $this->model->whereIn('forum_id', $forumIds)->delete();
        }
    }
}
