<?php namespace Kaamaru\Forums\Http\Controllers\Forums;

use Kaamaru\Forums\Forums\ForumRepoInterface;
use Kaamaru\Forums\Posts\PostRepoInterface;
use Kaamaru\Forums\Topics\TopicRepoInterface;
use Kaamaru\Forums\Http\Controllers\BaseController;

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
