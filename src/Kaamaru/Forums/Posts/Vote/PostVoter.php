<?php namespace Kaamaru\Forums\Posts\Vote;

use Kaamaru\Forums\Posts\EloquentPostRepo;

/**
 * Class PostVoter
 *
 * @package Kaamaru\Forums\Posts\Votes
 */
class PostVoter
{
    public function __construct(EloquentPostRepo $post, EloquentPostVoteRepo $vote)
    {
        $this->voteRepo = $vote;
        $this->postRepo = $post;
    }

    /**
     * Increment post vote count
     *
     * @param $postId
     * @param $userId
     * @return void
     */
    public function increment($postId, $userId)
    {
        $vote = $this->voteRepo->getForPost($postId, $userId);

        if (is_null($vote)) {
            $this->postRepo->incrementVote($postId);
            $this->voteRepo->incrementVote($postId, $userId);
        } elseif ($vote->positive == false) {
            $this->postRepo->incrementVote($postId);
            $this->voteRepo->deleteById($vote->id);
        }
    }

    /**
     * Decrement post vote count
     *
     * @param $postId
     * @param $userId
     * @return void
     */
    public function decrement($postId, $userId)
    {
        $vote = $this->voteRepo->getForPost($postId, $userId);

        if (is_null($vote)) {
            $this->postRepo->decrementVote($postId);
            $this->voteRepo->decrementVote($postId, $userId);
        } elseif ($vote->positive == true) {
            $this->postRepo->decrementVote($postId);
            $this->voteRepo->deleteById($vote->id);
        }
    }
}
