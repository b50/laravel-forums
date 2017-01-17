<?php namespace B50\Forums\Http\Controllers\Topics;

use B50\Forums\Topics\TopicBuilder;
use B50\Forums\Topics\TopicRepoInterface;
use B50\Forums\Http\Controllers\BaseController;
use B50\Forums\Topics\TopicSort;

/**
 * The topics controller
 *
 * @package App\Controllers\Forums
 */
class TopicsController extends BaseController
{
    /**
     * @var TopicRepoInterface
     */
    private $topicRepo;

    /**
     * @var TopicBuilder
     */
    private $topicBuilder;

    /**
     * @param TopicRepoInterface $topic
     * @param TopicBuilder $tb
     */
    public function __construct(TopicRepoInterface $topic, TopicBuilder $tb)
    {
        $this->topicRepo = $topic;
        $this->topicBuilder = $tb;
    }

    /**
     * Show all topics
     * @param TopicSort $sort
     * @return \Illuminate\Contracts\View\View
     */
    public function getIndex(TopicSort $sort)
    {
        $topics = $this->topicRepo->getAll(
            $sort->getField(),
            $sort->getDirection()
        );
        return \View::make('lforums.all_topics',
            compact('topics'), ['sort' => $sort]);
    }

    /**
     * Show a topic.
     *
     * @param $id
     * @return \Illuminate\Contracts\View\View
     */
    public function getTopic($id)
    {
        $topic = $this->topicBuilder->build($id);

        // Is it a suggestion topic?
        if ($topic->path and last($topic->parents)->type == 'suggestions') {
            $view = 'lforums.suggestion_topic';
            return \View::make(view, compact('topic'));
        }

        return \View::make('lforums.topics.topic',
            compact('topic', 'topicType'));
    }
}
