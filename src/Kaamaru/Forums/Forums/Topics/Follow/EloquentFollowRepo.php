<?php namespace Kaamaru\Forums\Forums\Topics\Follow;

use Kaamaru\Forums\Core\Repositories\EloquentRepo;

/**
 * Class EloquentFollowRepo
 *
 * @package Kaamaru\Forums\Forums\Topics\Follow
 */
class EloquentFollowRepo extends EloquentRepo implements FollowRepoInterface
{
    public function __construct(EloquentFollow $follow)
    {
        $this->model = $follow;
    }

    /**
     * {@inheritDoc}
     */
    public function follow($topicId, $userId)
    {
        $this->model->insert(['topic_id' => $topicId, 'user_id' => $userId]);
    }

    /**
     * {@inheritDoc}
     */
    public function unfollow($topicId, $userId)
    {
        $this->model->where('topic_id', $topicId)->where('user_id', $userId)->delete();
    }
}
