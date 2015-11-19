<?php namespace Kaamaru\Forums\Forums\Topics\Create;

use Kaamaru\Forums\Forums\Preview;
use Kaamaru\Forums\Forums\Topics\TopicValidator;

/**
 * Create a topic
 *
 * @package App\Forums\TopicMoveService
 */
class CreateTopicRequest
{
    /**
     * @var Preview
     */
    private $preview;

    /**
     * @internal param TopicListenerInterface $listener
     * @param TopicValidator $validator
     * @param TopicCreator $creator
     * @param Preview $preview
     */
    public function __construct(TopicValidator $validator, TopicCreator $creator, Preview $preview)
    {
        $this->validator = $validator;
        $this->topicCreator = $creator;
        $this->preview = $preview;
    }

    /**
     * Move topic
     *
     * @param TopicCreateListener $listener
     * @param                     $input
     * @param                     $user
     * @internal param $topic
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create(TopicCreateListener $listener, $input, $user)
    {
        if (!$this->validator->validate($input)) {
            return $listener->topicCreationFailed($this->validator->errors());
        }

        // Show preview
        if (isset($input['preview'])) {
            // Create preview
            $topic = $this->preview->generateTopic($input);
            $post = $this->preview->generatePost($input, \Auth::user());

            return $listener->showPreview($post, $topic);
        }

        // Go back from preview
        if (isset($input['back'])) {
            $listener->backFromPreview();
        }

        // Create topic
        $topic = $this->topicCreator->create($input, $user);

        return $listener->topicCreated($topic);
    }
}
