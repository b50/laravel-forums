<?php namespace Kaamaru\Forums\Forums\Posts\Report;

/**
 * Report post
 *
 * @package Kaamaru\Forums\Forums\Posts\Report
 */
class PostReporter
{
    public function __construct(PostReportRepoInterface $report)
    {
        $this->reportRepo = $report;
    }

    /**
     * Report post
     *
     * @param $postId
     * @param $userId
     * @return bool
     */
    public function report($postId, $userId)
    {
        $report = $this->reportRepo->getByPostId($postId, $userId);

        if (!$report) {
            $this->reportRepo->report($postId, $userId);
        }

        return !(bool)$report;
    }
}
