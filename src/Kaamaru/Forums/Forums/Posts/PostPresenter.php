<?php namespace Kaamaru\Forums\Forums\Posts;

use Carbon\Carbon;
use McCool\LaravelAutoPresenter\BasePresenter;

/**
 * Present the post
 *
 * @package Kaamaru\Forums\Forums\Forums
 */
class PostPresenter extends BasePresenter
{
    /**
     * @param EloquentPost $post
     */
    public function __construct(EloquentPost $post)
    {
        $this->resource = $post;
    }

    /**
     * Convert to readable date
     *
     * @return int
     */
    public function created_at()
    {
        if (is_null($this->resource->created_at)) {
            return Carbon::now()->diffForHumans();
        }

        return $this->resource->created_at->diffForHumans();
    }

    /**
     * For quotes
     *
     * @return mixed
     */
    public function created_at_date()
    {
        return $this->resource->created_at;
    }
}
