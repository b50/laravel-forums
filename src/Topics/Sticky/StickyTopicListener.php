<?php namespace B50\Forums\Topics\Sticky;

/**
 * Interface TopicMoverInterface
 *
 * @package App\Forums
 */
interface StickyTopicListener
{
    /**
     * Topic stickied
     *
     * @param $topic
     * @return \Illuminate\Http\RedirectResponse
     */
    public function topicStickied($topic);

    /**
     * Topic unstickied
     *
     * @param $topic
     * @return \Illuminate\Http\RedirectResponse
     */
    public function topicUnstickied($topic);
}
