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
     * @param TopicRepoInterface $topicRepo
     * @param PostRepoInterface $postRepo
     * @param ForumRepoInterface $forumRepo
     * @return \Illuminate\Contracts\View\View
     */
    public function getIndex(
        TopicRepoInterface $topicRepo,
        PostRepoInterface $postRepo,
        ForumRepoInterface $forumRepo
    ) {
        $forums = $forumRepo->getForums();

        // Get sidebar info
        $recentPosts = $postRepo->getRecent();
        $recentTopics = $topicRepo->getRecent();

        return \View::make(
            'lforums/forums',
            compact('forums', 'recentTopics', 'recentPosts')
        );
    }
}
