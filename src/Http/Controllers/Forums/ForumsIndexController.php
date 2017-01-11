<?php namespace B50\Forums\Http\Controllers\Forums;

use B50\Forums\Forums\ForumRepoInterface;
use B50\Forums\Posts\PostRepoInterface;
use B50\Forums\Topics\TopicRepoInterface;
use B50\Forums\Http\Controllers\BaseController;

/**
 * The forums index controller
 */
class ForumsIndexController extends BaseController
{
    /**
     * Show the forums index
     *
     * @param TopicRepoInterface $topic
     * @param PostRepoInterface $post
     * @param ForumRepoInterface $forum
     * @return \Illuminate\View\View
     */
    public function getIndex(
        TopicRepoInterface $topic,
        PostRepoInterface $post,
        ForumRepoInterface $forum
    ) {
        $forums = $forum->getForums();

        // Get sidebar info
        $recentPosts = $post->getRecent();
        $recentTopics = $topic->getRecent();

        return \View::make(
            'lforums/forums',
            compact('forums', 'recentTopics', 'recentPosts')
        );
    }
}
