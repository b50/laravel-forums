<?php namespace Kaamaru\Forums\Forums\Topics\Move;

/**
 * Interface TopicMoverInterface
 *
 * @package App\Forums
 */
interface TopicMoverListener
{
    /**
     * Topic move failed
     *
     * @param $topic
     * @param $errors
     * @return \Illuminate\Http\RedirectResponse
     */
    public function moveTopicFailed($topic, $errors);

    /**
     * Topic Move was a success
     *
     * @param $topic
     * @return \Illuminate\Http\RedirectResponse
     */
    public function moveTopicSucceeded($topic);
}
