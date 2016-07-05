<?php namespace Kaamaru\Forums\Http\Controllers\Topics;

use Kaamaru\Forums\Core\Auth\AuthorizeTrait;
use Kaamaru\Forums\Topics\Sticky\StickyTopic;
use Kaamaru\Forums\Topics\Sticky\StickyTopicListener;
use Kaamaru\Forums\Topics\TopicRepoInterface;

/**
 * Sticky topics controller
 *
 * @package App\Controllers\Forums
 */
class StickyTopicsController extends BaseTopicsController implements StickyTopicListener
{
    use AuthorizeTrait;

    /**
     * @param TopicRepoInterface $topic
     * @param StickyTopic $sticky
     */
    public function __construct(TopicRepoInterface $topic, StickyTopic $sticky)
    {
        $this->topicRepo = $topic;
        $this->sticky = $sticky;
    }

    /**
     * Make topic sticky
     *
     * @param int $id
     * @return Illuminate\Http\RedirectResponse
     */
    public function getSticky($topicType, $id)
    {
        $topic = $this->topicRepo->requireById($id);

        if ($response = $this->noAccessNotOwner('forums.topics.delete', $topic)) {
            return $response;
        }

        return $this->sticky->sticky($this, $topic);
    }

    /**
     * {@inheritDoc}
     */
    public function topicStickied($topic)
    {
        \Flash::success(_('The topic is now sticky!'));
        return $this->redirectToTopic($topic);
    }

    /**
     * {@inheritDoc}
     */
    public function topicUnstickied($topic)
    {
        \Flash::success(_('The topic is no longer sticky!'));
        return $this->redirectToTopic($topic);
    }

    /**
     * {@inheritDocs}
     */
    public function noAccessReturn($topic)
    {
        \Flash::danger(_('You have no glue to sticky this topic.'));
        return $this->redirectToTopic($topic);
    }
}
