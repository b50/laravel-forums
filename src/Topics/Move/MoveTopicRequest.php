<?php namespace Kaamaru\Forums\Topics\Move;

use Kaamaru\Forums\Topics\RedirectionTopic;

/**
 * Move a topic
 *
 * @package App\Forums\TopicMoveService
 */
class MoveTopicRequest
{
    /**
     * @param MoveTopicValidator $validator
     * @param TopicMover $mover
     * @param RedirectionTopic $redirect
     */
    public function __construct(MoveTopicValidator $validator, TopicMover $mover, RedirectionTopic $redirect)
    {
        $this->validator = $validator;
        $this->redirect = $redirect;
        $this->topicMover = $mover;
    }

    /**
     * Move topic
     *
     * @param TopicMoverListener $listener
     * @param                    $input
     * @param                    $topic
     * @return \Illuminate\Http\RedirectResponse
     */
    public function move(TopicMoverListener $listener, $input, $topic)
    {
        // Validate
        $this->validator->setCurrentForum($topic->path);

        if (!$this->validator->validate($input)) {
            return $listener->moveTopicFailed($topic, $this->validator->errors());
        };

        // Move topic
        $this->topicMover->move($topic, $input);

        // Create redirection topic
        if (isset($input['redirection'])) {
            $this->redirect->make($input['forum'], $topic, \Auth::user());
        }

        return $listener->moveTopicSucceeded($topic);
    }
}
