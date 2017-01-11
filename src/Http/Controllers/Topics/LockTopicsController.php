<?php namespace B50\Forums\Http\Controllers\Topics;

use B50\Forums\Core\Auth\AuthorizeTrait;
use B50\Forums\Topics\Lock\LockTopic;
use B50\Forums\Topics\Lock\LockTopicListener;
use B50\Forums\Topics\TopicRepoInterface;

/**
 * The topics controller
 *
 * @package App\Controllers\Forums
 */
class LockTopicsController extends BaseTopicsController implements LockTopicListener
{
    use AuthorizeTrait;

    /**
     * @param TopicRepoInterface $topic
     * @param LockTopic $lock
     */
    public function __construct(TopicRepoInterface $topic, LockTopic $lock)
    {
        $this->topicRepo = $topic;
        $this->lock = $lock;
    }

    /**
     * Lock topic
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getLock($topicType, $id)
    {
        $topic = $this->topicRepo->requireById($id);

        if ($response = $this->noAccess('forums.topics.lock', $topic)) {
            return $response;
        }

        return $this->lock->lock($this, $topic);
    }

    /**
     * {@inheritDoc}
     */
    public function topicLocked($topic)
    {
        \Flash::success(_('The topic is now locked!'));
        return $this->redirectToTopic($topic);
    }

    /**
     * {@inheritDoc}
     */
    public function topicUnlocked($topic)
    {
        \Flash::success(_('The topic is no longer locked!'));
        return $this->redirectToTopic($topic);
    }

    /**
     * {@inheritDocs}
     */
    public function noAccessReturn($topic)
    {
        \Flash::danger(_("You don't have permission to lock topics."));
        return $this->redirectToTopic($topic);
    }
}
