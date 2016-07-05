<?php namespace Kaamaru\Forums\Http\Controllers\Topics;

use Kaamaru\Forums\Forums\ForumRepoInterface;
use Kaamaru\Forums\Topics\Read\TopicReadRepoInterface;
use Kaamaru\Forums\Topics\TopicRepoInterface;
use Kaamaru\Forums\Http\Controllers\BaseController;

/**
 * The topics controller
 *
 * @package App\Controllers\Forums
 */
class ReadTopicsController extends BaseController
{
    /**
     * @param TopicRepoInterface $topic
     * @param ForumRepoInterface $forum
     * @param TopicReadRepoInterface $read
     */
    public function __construct(TopicRepoInterface $topic, ForumRepoInterface $forum, TopicReadRepoInterface $read)
    {
        $this->forumRepo = $forum;
        $this->topicRepo = $topic;
        $this->readRepo = $read;
    }

    /**
     * Mark topic as unread
     *
     * @param string $topicType
     * @param int $id topic id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getUnread($topicType, $id)
    {
        // Unmark topic as read
        $this->readRepo->clearRead($id, \Auth::user()->id);

        return $this->readRedirect($topicType, $id);
    }

    /**
     * Mark topic as read
     *
     * @param string $topicType
     * @param int $id topic id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getRead($topicType, $id)
    {
        // Unmark topic as read
        $this->readRepo->markAsRead($id, \Auth::user()->id);

        return $this->readRedirect($topicType, $id);
    }

    /**
     * Redirect back
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function readRedirect($topicType, $id)
    {
        $topic = $this->topicRepo->requireById($id);
        $forum = $this->forumRepo->requireById(last($topic->pathExplode()));
        return Redirect::route('forums.show', ['id' => $forum->id, 'slug' => $forum->slug]);

        return Redirect::to('/');
    }
}
