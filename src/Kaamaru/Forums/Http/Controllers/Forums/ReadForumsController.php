<?php namespace Kaamaru\Forums\Http\Controllers\Forums;

use Kaamaru\Forums\Forums\Forums\ForumRepoInterface;
use Kaamaru\Forums\Forums\Forums\Read\ForumReadRepoInterface;
use Kaamaru\Forums\Http\Controllers\BaseController;

/**
 * The forums controller
 */
class ReadForumsController extends BaseController
{
    /**
     * @param ForumRepoInterface $forum
     * @param ForumReadRepoInterface $read
     */
    public function __construct(ForumRepoInterface $forum, ForumReadRepoInterface $read)
    {
        $this->forumRepo = $forum;
        $this->readRepo = $read;
    }

    /**
     * Mark forum as unread
     *
     * @param int $id topic id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getUnread($id)
    {
        // Unmark forum as read
        $this->readRepo->clearRead([$id], \Auth::user()->id);

        return $this->readRedirect($id);
    }

    /**
     * Mark forum as read
     *
     * @param int $id topic id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getRead($id)
    {
        // Unmark forum as read
        $this->readRepo->markAsRead($id, \Auth::user()->id);

        return $this->readRedirect($id);
    }

    /**
     * Redirect back after read
     */
    protected function readRedirect($id)
    {
        // Redirect to index
        if (\Input::get('index')) {
            return Redirect::route('forums.index');
        }

        // Get forum
        $forum = $this->forumRepo->requireById($id);

        // Redirect to forum if the forum has a parent
        if ($parent = $forum->parent()) {
            $parent = $this->forumRepo->requireById($parent);

            return Redirect::route('forums.show', ['id' => $parent->id, $parent->slug]);
        }

        // No parent, redirect back to the index
        return Redirect::route('forums.index');
    }
}
