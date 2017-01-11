<?php namespace Kaamaru\Forums\Http\Controllers\Topics;

use Kaamaru\Forums\Core\Auth\AuthorizeTrait;
use Kaamaru\Forums\Forums\ForumTree;
use Kaamaru\Forums\Topics\Move\MoveTopicRequest;
use Kaamaru\Forums\Topics\Move\TopicMoverListener;
use Kaamaru\Forums\Topics\TopicRepoInterface;
use Kaamaru\Forums\Http\Controllers\BaseController;

/**
 * The topics controller
 *
 * @package App\Controllers\Forums
 */
class MoveTopicsController extends BaseController implements TopicMoverListener
{
    use AuthorizeTrait;

    /**
     * @param TopicRepoInterface $topic
     * @param ForumTree $tree
     * @param MoveTopicRequest $moveRequest
     */
    public function __construct(TopicRepoInterface $topic, ForumTree $tree, MoveTopicRequest $moveRequest)
    {
        $this->topicRepo = $topic;
        $this->tree = $tree;
        $this->moveRequest = $moveRequest;
    }

    /**
     * Show move topic page
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function getMove($topicType, $id)
    {
        $topic = $this->topicRepo->requireById($id);

        if ($response = $this->noAccess('forums.topics.move', $topic)) {
            return $response;
        }

        $tree = $this->tree->getTree();

        return \View::make('kaamaru.laravel-forums.forums.move', compact('topic', 'tree'));
    }

    /**
     * Move a topic
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postMove($topicType, $id)
    {
        $topic = $this->topicRepo->requireById($id);

        if ($response = $this->noAccess('forums.topics.move', $topic)) {
            return $response;
        }

        return $this->moveRequest->move($this, \Input::all(), $topic);
    }

    /**
     * {@inheritDoc}
     */
    public function moveTopicFailed($topic, $errors)
    {
        return \Redirect::route('forums.topics.move', ['id' => $topic->id, 'slug' => $topic->slug])
            ->withInput()->withErrors($errors);
    }

    /**
     * {@inheritDoc}
     */
    public function moveTopicSucceeded($topic)
    {
        return \Redirect::route('forums.topics.show', ['id' => $topic->id, 'slug' => $topic->slug]);
    }

    /**
     * {@inheritDocs}
     */
    public function noAccessReturn($topic)
    {
        \Flash::danger(_('You are not a qualified mover.'));
        return \Redirect::route('forums.topics.show', ['id' => $topic->id, 'slug' => $topic->slug]);
    }
}
