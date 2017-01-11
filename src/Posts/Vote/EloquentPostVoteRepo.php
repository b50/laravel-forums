<?php namespace Kaamaru\Forums\Posts\Vote;

use Kaamaru\Forums\Core\Repositories\EloquentRepo;

/**
 * EloquentPostVote repository
 *
 * @package Kaamaru\Forums\Posts\Vote
 */
class EloquentPostVoteRepo extends EloquentRepo implements PostVoteRepoInterface
{
    public function __construct(EloquentPostVote $vote)
    {
        $this->model = $vote;
    }

    /**
     * {@inheritDoc}
     */
    public function getForPost($postId, $userId)
    {
        return $this->model->where('post_id', $postId)->where('user_id', $userId)->first();
    }

    /**
     * {@inheritDoc}
     */
    public function deleteById($id)
    {
        $this->model->where('id', $id)->delete();
    }

    /**
     * {@inheritDoc}
     */
    public function incrementVote($postId, $userId)
    {
        $this->model->insert([
            'post_id' => $postId,
            'user_id' => $userId,
            'positive' => true
        ]);
    }

    /**
     * {@inheritDoc}
     */
    public function decrementVote($postId, $userId)
    {
        $this->model->insert([
            'post_id' => $postId,
            'user_id' => $userId,
            'positive' => false
        ]);
    }
}
