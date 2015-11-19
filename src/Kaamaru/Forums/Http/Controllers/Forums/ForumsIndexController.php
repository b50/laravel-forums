<?php namespace Kaamaru\Forums\Http\Controllers\Forums;

use Kaamaru\Forums\Forums\Forums\ForumRepoInterface;
use Kaamaru\Forums\Forums\Posts\PostRepoInterface;
use Kaamaru\Forums\Forums\Topics\TopicRepoInterface;
use Kaamaru\Forums\Http\Controllers\BaseController;

/**
 * The forums index controller
 */
class ForumsIndexController extends BaseController
{
    /**
     * @param TopicRepoInterface $topic
     * @param PostRepoInterface $post
     * @param ForumRepoInterface $forum
     */
    public function __construct(TopicRepoInterface $topic, PostRepoInterface $post, ForumRepoInterface $forum)
    {
        $this->topicRepo = $topic;
        $this->postRepo = $post;
        $this->forumRepo = $forum;
    }

    /**
     * Forums index
     *
     * @return \Illuminate\View\View
     */
    public function getIndex()
    {
        $forums = $this->forumRepo->getForums();

        // Get sidebar info
        $recentPosts = $this->postRepo->getRecent();
        $recentTopics = $this->topicRepo->getRecent();

        return \View::make('Kaamaru\Forums::forums.forums', compact('forums', 'recentTopics', 'recentPosts'));
    }
}
