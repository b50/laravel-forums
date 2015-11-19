<?php namespace Kaamaru\Forums\Http\Controllers\Topics;

use Kaamaru\Forums\Core\Auth\AuthorizeTrait;
use Kaamaru\Forums\Forums\Forums\ForumRepoInterface;
use Kaamaru\Forums\Forums\Topics\Delete\TopicDeleteListener;
use Kaamaru\Forums\Forums\Topics\Delete\TopicDeleter;
use Kaamaru\Forums\Forums\Topics\TopicRepoInterface;

/**
 * The topics controller
 *
 * @package App\Controllers\Forums
 */
class DeleteTopicsController extends BaseController implements TopicDeleteListener
{
    use AuthorizeTrait;

    /**
     * @param TopicRepoInterface $topic
     * @param TopicDeleter $delete
     * @param ForumRepoInterface $forum
     * @internal param ForumRepoInterface $forum
     */
    public function __construct(TopicRepoInterface $topic, TopicDeleter $delete, ForumRepoInterface $forum)
    {
        $this->topicRepo = $topic;
        $this->topicDeleter = $delete;
        $this->forumRepo = $forum;
    }

    /**
     * Show delete conformation
     *
     * @param int $id
     * @return Illuminate\View\View
     */
    public function getDelete($topicType, $id)
    {
        $topic = $this->topicRepo->requireById($id);

        if ($response = $this->noAccessNotOwner('forums.topics.delete', $topic)) {
            return $response;
        }

        return View::make($topicType . '.topics.delete', compact('topic'));
    }

    /**
     * Delete topic
     *
     * @param int $id
     * @return Illuminate\Http\RedirectResponse
     */
    public function postDelete($topicType, $id)
    {
        $topic = $this->topicRepo->requireById($id);

        if ($response = $this->noAccessNotOwner('forums.topics.delete', $topic)) {
            return $response;
        }

        return $this->topicDeleter->delete($this, $topic);
    }

    /**
     * {@inheritDoc}
     */
    public function topicDeleted($topic)
    {
        Flash::success('Topic deleted!');

        $forum = $this->forumRepo->getById(last($topic->pathExplode()));
        return Redirect::route('forums.show', ['id' => $forum->id, 'slug' => $forum->slug]);
    }

    /**
     * {@inheritDocs}
     */
    public function noAccessReturn($topic)
    {
        Flash::danger(_("You can't delete this topic :/"));
        return Redirect::route('forums.topics.show', ['id' => $topic->id, 'slug' => $topic->slug]);
    }
}
