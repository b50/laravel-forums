<?php namespace B50\Forums\Http\Controllers\Topics;

use B50\Forums\Http\Controllers\BaseController;

/**
 * Base topics controller
 */
class BaseTopicsController extends BaseController
{
    /**
     * @param $topic
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function redirectToTopic($topic)
    {
        return \Redirect::route('forums.topics.show', [
            'topicType' => \Route::current()->parameter('topicType'),
            'id' => $topic->id,
            'slug' => $topic->slug
        ]);
    }
}
