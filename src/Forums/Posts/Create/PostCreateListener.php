<?php namespace LaravelForums\Forums\Posts\Create;

/**
 * Interface TopicMoverInterface
 *
 * @package App\Forums
 */
interface PostCreateListener {

	/**
	 * Successfully replied to a topic
	 *
	 * @param $post
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function postCreateSucceeded($post);

	/**
	 * Failed to reply to the topic
	 *
	 * @param \Illuminate\Support\MessageBag $errors
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function postCreateFailed($errors);

	/**
	 * @param $postPreview
	 * @return mixed
	 */
	public function showPreview($postPreview);

	/**
	 * Go back from a preview
	 *
	 * @return \Illuminate\View\View
	 */
	public function backFromPreview();

}
