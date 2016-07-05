<?php namespace Kaamaru\Forums\Http\Controllers\Topics;

use Kaamaru\Forums\Topics\TopicBuilder;
use Kaamaru\Forums\Topics\TopicRepoInterface;
use Kaamaru\Forums\Http\Controllers\BaseController;

/**
 * The topics controller
 *
 * @package App\Controllers\Forums
 */
class TopicsController extends BaseController
{
    /**
     * @param TopicRepoInterface $topic
     * @param TopicBuilder $topicBuilder
     */
    public function __construct(TopicRepoInterface $topic, TopicBuilder $topicBuilder)
    {
        $this->topicRepo = $topic;
        $this->topicBuilder = $topicBuilder;
    }

    /**
     * Show all topics
     */
    public function getIndex()
    {
        $topics = $this->topicRepo->getAll(
            $this->sort->getField(), 
            $this->sort->getDirection()
        );
        return \View::make('lforums.forums.all_topics', 
            compact('topics'), ['sort' => $this->sort]);
    }

    /**
     * Show a topic
     *
     * @param string $topicType
     * @param int $id
     * @return Illuminate\Views\View
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
