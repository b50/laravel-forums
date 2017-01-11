<?php namespace B50\Forums\Forums;

use Carbon\Carbon;
use McCool\LaravelAutoPresenter\BasePresenter;

/**
 * Present the forum
 *
 * @package B50\Forums\Forums
 */
class ForumPresenter extends BasePresenter
{
    /**
     * @param EloquentForum $forum
     */
    public function __construct(EloquentForum $forum)
    {
        $this->resource = $forum;
    }

    /**
     * Convert to readable date
     *
     * @return int
     */
    public function last_topic_updated_at()
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->resource->last_topic_updated_at)->diffForHumans();
    }
}
