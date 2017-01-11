<?php namespace Kaamaru\Forums\Http\Controllers\Posts;

use Kaamaru\Forums\Core\Auth\AuthorizeTrait;
use Kaamaru\Forums\Posts\Delete\PostDeleter;
use Kaamaru\Forums\Posts\Delete\PostDeleterListener;
use Kaamaru\Forums\Posts\PostRepoInterface;

/**
 * Class PostsController
 *
 * @package App\Controllers\Forums
 */
class DeletePostsController extends BasePostsController implements PostDeleterListener
{
    use AuthorizeTrait;

    /**
     * @param PostRepoInterface $posts
     * @param PostDeleter $deleter
     */
    public function __construct(PostRepoInterface $posts, PostDeleter $deleter)
    {
        $this->postsRepo = $posts;
        $this->post = $this->postsRepo->requireById(Route::current()->parameter('id'));
        $this->deleter = $deleter;
    }

    /**
     * Show delete post page
     *
     * @return \Illuminate\View\View
     */
    public function getDelete($topicType)
    {
        if ($response = $this->noAccessNotOwner('forums.posts.delete', $this->post)) {
            return $response;
        }

        return View::make($topicType . '.posts.delete', ['post' => $this->post]);
    }

    /**
     * Delete a post
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postDelete()
    {
        if ($response = $this->noAccessNotOwner('forums.posts.delete', $this->post)) {
            return $response;
        }

        return $this->deleter->delete($this, \Input::all(), $this->post);
    }

    /**
     * {@inheritDocs}
     */
    public function postDeleted()
    {
        Flash::success(_("Post deleted :D"));
        return $this->redirectToTopic();
    }

    /**
     * {@inheritDocs}
     */
    public function cantDeleteFirstPost()
    {
        Flash::danger(_("You can't delete the first post in a topic"));
        return Redirect::route('forums.posts.delete', [
            'topicType' => Route::current()->parameter('topicType'),
            'post' => $this->post->id
        ]);
    }

    /**
     * {@inheritDocs}
     */
    public function noAccessReturn($topic)
    {
        Flash::success(_('You cannot delete this post. Nice try though!'));
        return $this->redirectToTopic($topic);
    }
}
