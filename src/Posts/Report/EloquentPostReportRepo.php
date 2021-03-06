<?php namespace B50\Forums\Posts\Report;

use B50\Forums\Core\Repositories\EloquentRepo;

/**
 * EloquentPostReport repository
 *
 * @package B50\Forums\Posts\Report
 */
class EloquentPostReportRepo extends EloquentRepo implements PostReportRepoInterface
{
    public function __construct(EloquentPostReport $report)
    {
        $this->model = $report;
    }

    /**
     * {@inheritDoc}
     */
    public function report($postId, $userId)
    {
        $this->model->insert([
            'post_id' => $postId,
            'user_id' => $userId,
        ]);
    }

    /**
     * Get report for a post
     *
     * @param $postId
     * @param $userId
     * @return mixed
     */
    public function getByPostId($postId, $userId)
    {
        return $this->model->where('post_id', $postId)->where('user_id', $userId)->first();
    }
}
