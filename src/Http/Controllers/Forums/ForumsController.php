<?php namespace B50\Forums\Http\Controllers\Forums;

use Illuminate\Support\Facades\View;
use B50\Forums\Forums\ForumRepoInterface;
use B50\Forums\Read\ForumReadRepoInterface;
use B50\Forums\Topics\TopicRepoInterface;
use B50\Forums\Topics\TopicSort;
use B50\Forums\Http\Controllers\BaseController;

/**
 * The forums controller
 */
class ForumsController extends BaseController
{
    /**
     * @var ForumRepoInterface
     */
    private $forumRepo;

    /**
     * @var ForumReadRepoInterface
     */
    private $readRepo;

    /**
     * @var TopicSort
     */
    private $topicSort;

    /**
     * @var TopicRepoInterface
     */
    private $topicRepo;

    /**
     * @param ForumRepoInterface $forum
     * @param ForumReadRepoInterface $read
     * @param TopicSort $topicSort
     * @param TopicRepoInterface $topic
     */
    public function __construct(
        ForumRepoInterface $forum,
        ForumReadRepoInterface $read,
        TopicSort $topicSort,
        TopicRepoInterface $topic
    )
    {
        $this->forumRepo = $forum;
        $this->readRepo = $read;
        $this->topicSort = $topicSort;
        $this->topicRepo = $topic;
    }

    /**
     * Get a forum by it's id
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\View
     */
    public function getForum($id)
    {
        // Get forums
        $forum = $this->forumRepo->requireById($id);
        $subforums = $this->forumRepo->getSubforums($forum);

        // Mark forum as read
        if (\Auth::check()) {
            $this->readRepo->markAsRead($forum->id, \Auth::user()->id);
        }

        if ($forum->type == 'suggestions') {

            // Get topics and order by vote
            $this->topicSort->setDefaultField('first_post.votes');
            $topics = $this->topicRepo->getForSuggestionForum(
                $forum->path,
                $this->topicSort->getField(),
                $this->topicSort->getDirection()
            );

            return \View::make('lforums.suggestion',
                compact('forum', 'subforums', 'topics'),
                ['sort' => $this->topicSort]
            );
        }

        // Get topics
        $topics = $this->topicRepo->getForForum(
            $forum->id,
            $this->topicSort->getField(),
            $this->topicSort->getDirection()
        );

        return View::make('lforums.forum', compact('forum', 'topics', 'subforums'),
            ['sort' => $this->topicSort]);
    }
}
