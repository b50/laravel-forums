<?php namespace B50\Forums\Http\Controllers\Topics;

use Illuminate\Http\Request;
use B50\Forums\Posts\Create\CreatePostRequest;
use B50\Forums\Posts\Create\PostCreateListener;
use B50\Forums\Posts\PostRepoInterface;
use B50\Forums\Topics\TopicRepoInterface;
use B50\Forums\Http\Controllers\BaseController;

/**
 * The topics controller
 *
 * @package App\Controllers\Forums
 */
class ReplyTopicsController extends BaseController implements PostCreateListener
{
    /**
     * @var TopicRepoInterface
     */
    private $topicRepo;

    /**
     * @var PostRepoInterface
     */
    private $postRepo;

    /**
     * @var CreatePostRequest
     */
    private $createRequest;

    /**
     * @var mixed
     */
    private $topic;

    /**
     * @param TopicRepoInterface $topic
     * @param PostRepoInterface $post
     * @param CreatePostRequest $create
     */
    public function __construct(TopicRepoInterface $topic, PostRepoInterface $post, CreatePostRequest $create)
    {
        $this->topicRepo = $topic;
        $this->postRepo = $post;
        $this->createRequest = $create;
        $this->topic = $this->topicRepo->requireById(\Route::current()->getParameter('id'));
    }

    /**
     * Reply to topic page
     *
     * @param Request $request
     * @param int $id topic id
     * @return \Illuminate\Contracts\View\View
     */
    public function getReply(Request $request, $id)
    {
        // Get quotes
        $quotes = array_filter(array_merge((array)$request->input('quotes'), [$request->input('quote')]));
        $quotes = $this->postRepo->getById($quotes);

        return \View::make('lforums.topics.reply', compact('quotes'), ['topic' => $this->topic]);
    }

    /**
     * Post reply to topic
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postReply()
    {
        return $this->createRequest->create($this, \Input::all(), $this->topic, Auth::getUser());
    }

    /**
     * {@inheritDoc}
     */
    public function showPreview($post)
    {
        return View::make(\Route::current()->parameter('topicType') . '.topics.reply_preview',
            ['post' => $post, 'topic' => $this->topic, 'button' => _('Reply')]);
    }

    /**
     * {@inheritDoc}
     */
    public function postCreateSucceeded($post)
    {
        \Flash::success(_('Successfully replied to the topic. :)'));
        return Redirect::route('forums.posts.show',
            ['topicType' => \Route::current()->parameter('topicType'), 'id' => $post->id]);
    }

    /**
     * {@inheritDoc}
     */
    public function postCreateFailed($errors)
    {
        return Redirect::route('forums.topics.reply', [
            'topicType' => \Route::current()->parameter('topicType'),
            'id' => $this->topic->id,
            'slug' => $this->topic->slug
        ])->withInput()->withErrors($errors);
    }

    /**
     * Go back from a preview
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function backFromPreview()
    {
        return $this->getReply(\Route::current()->getParameter('topicType'));
    }
}
