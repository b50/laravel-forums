<?php namespace B50\Forums\Topics\Create;

/**
 * Interface TopicMoverInterface
 *
 * @package App\Forums
 */
interface TopicCreateListener
{
    /**
     * Topic has been created
     *
     * @param $topic
     * @return \Illuminate\Http\RedirectResponse
     */
    public function topicCreated($topic);

    /**
     * Failed to create topic
     *
     * @param $errors
     * @return \Illuminate\Http\RedirectResponse
     */
    public function topicCreationFailed($errors);

    /**
     * Topic has been created
     *
     * @param $topic
     * @param $post
     * @return \Illuminate\Http\RedirectResponse
     */
    public function showPreview($topic, $post);

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function backFromPreview();
}
