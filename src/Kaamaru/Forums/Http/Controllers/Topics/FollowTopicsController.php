<?php namespace Kaamaru\Forums\Http\Controllers\Topics;

use Kaamaru\Forums\Topics\Follow\FollowRepoInterface;
use Kaamaru\Forums\Topics\TopicRepoInterface;

/**
 * The topics controller
 *
 * @package App\Controllers\Forums
 */
class FollowTopicsController extends BaseTopicsController
{
    /**
     * @param TopicRepoInterface $topic
     * @param FollowRepoInterface $follow
     */
    public function __construct(TopicRepoInterface $topic, FollowRepoInterface $follow)
    {
        $this->topicRepo = $topic;
        $this->followRepo = $follow;
    }

    /**
     * Follow topic
     *
     * @param $id
     * @return mixed
     */
    public function getFollow($topicType, $id)
    {
        $topic = $this->topicRepo->requireById($id);

        // Unmark topic as read
        $this->followRepo->follow($topic->id, \Auth::user()->id);
        $this->topicRepo->increment($topic->id, 'followers');

        Flash::success('You are now following this topic.');

        return $this->redirectToTopic($topic);
    }

    /**
     * Unfollow topic
     *
     * @param $id
     * @return mixed
     */
    public function getUnfollow($topicType, $id)
    {
        $topic = $this->topicRepo->requireById($id);

        // Unmark topic as read
        $this->followRepo->unfollow($topic->id, \Auth::user()->id);
        $this->topicRepo->decrement($topic->id, 'followers');

        Flash::success('You are no longer following this topic.');

        return $this->redirectToTopic($topic);
    }
}
