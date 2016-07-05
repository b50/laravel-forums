<?php namespace Kaamaru\Forums\Http\Controllers\Posts;

use Kaamaru\Forums\Posts\Edit\EditPostRequest;
use Kaamaru\Forums\Posts\Edit\PostEditListener;
use Kaamaru\Forums\Posts\PostRepoInterface;

/**
 * Class PostsController
 *
 * @package App\Controllers\Forums
 */
class EditPostsController extends BasePostsController implements PostEditListener
{
    /**
     * @param PostRepoInterface $post
     * @param EditPostRequest $request
     */
    public function __construct(PostRepoInterface $post, EditPostRequest $request)
    {
        $this->postRepo = $post;
        $this->editPostRequest = $request;

        $this->post = $this->postRepo->requireById(Route::current()->parameter('id'));
    }

    /**
     * {@inheritDoc}
     */
    public function getEdit()
    {
        if (!\Bouncer::hasPermissionOrIsOwner('forums.posts.edit', $this->post)) {
            return $this->cantEditPost();
        }

        // Show title edit info if first post
        $firstPost = $this->postRepo->isFirst($this->post);

        return View::make(\Route::current()->parameter('topicType') . '.posts.edit_post',
            ['post' => $this->post, 'firstPost' => $firstPost]);
    }

    /**
     * Edit post
     *
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function postEdit()
    {
        if (!\Bouncer::hasPermissionOrIsOwner('forums.posts.edit', $this->post)) {
            return $this->cantEditPost();
        }

        // Edit post
        return $this->editPostRequest->edit($this, \Input::all(), $this->post);
    }

    /**
     * {@inheritDoc}
     */
    public function showPreview($postPreview, $title = null)
    {
        return View::make(\Route::current()->parameter('topicType') . '.posts.edit_preview',
            compact('postPreview', 'title'),
            ['post' => $this->post, 'button' => _('Edit')]);
    }

    /**
     * {@inheritDoc}
     */
    public function postEditFailed($errors)
    {
        return Redirect::route('forums.posts.edit', [
            'topicType' => \Route::current()->parameter('topicType'),
            'post' => $this->post->id
        ])->withInput()->withErrors($errors);
    }

    /**
     * {@inheritDoc}
     */
    public function postEditSucceeded()
    {
        Flash::success(_('Successfully edited the post. :)'));
        return $this->getShow($this->post);
    }

    /**
     * Can't edit post. Wrong permissions or not owner.
     */
    protected function cantEditPost()
    {
        Flash::danger(_("You can't edit this post."));
        return $this->redirectToTopic();
    }
}
