<?php namespace Kaamaru\Forums\Forums\Posts\Edit;

/**
 * Interface TopicMoverInterface
 *
 * @package App\Forums
 */
interface PostEditListener
{
    /**
     * Successfully replied to a topic
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postEditSucceeded();

    /**
     * Failed to reply to the topic
     *
     * @param \Illuminate\Support\MessageBag $errors
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postEditFailed($errors);

    /**
     * Topic has been created
     *
     * @param $postPreview
     * @param $title
     * @return \Illuminate\Http\RedirectResponse
     */
    public function showPreview($postPreview, $title = null);

    /**
     * Show edit post page
     *
     * @return \Illuminate\View\View
     */
    public function getEdit();
}
