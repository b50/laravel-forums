<?php namespace Kaamaru\Forums\Topics;

use Kaamaru\Forums\Topics\Read\TopicReadRepoInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Builds topics
 *
 * @package Kaamaru\Forums\Topics
 */
class TopicBuilder
{
    /**
     * @param TopicRepoInterface $topic
     * @param TopicReadRepoInterface $read
     * @param TopicViewCounter $counter
     * @param TopicSort $sort
     */
    public function __construct(
        TopicRepoInterface $topic,
        TopicReadRepoInterface $read,
        TopicViewCounter $counter,
        TopicSort $sort
    ) {
        $this->topicRepo = $topic;
        $this->readRepo = $read;
        $this->viewCounter = $counter;
        $this->sort = $sort;
    }

    /**
     * Build topic
     *
     * @param $topicId
     * @return \Illuminate\View\View
     */
    public function build($topicId)
    {
        $topic = $this->topicRepo->getForTopicPage($topicId, \Auth::user());

        // Check has posts
        if (!$topic->posts->count()) {
            throw new NotFoundHttpException;
        }

        // Mark topic read
        if (\Auth::check()) {
            $this->readRepo->markAsRead($topic->id, \Auth::user()->id);
        }

        // Increment topic views
        $this->viewCounter->increment($topic->id);

        return $topic;
    }
}
