<?php namespace Kaamaru\Forums\Posts\Create;

use Kaamaru\Forums\Forums\Preview;
use Kaamaru\Forums\Posts\PostValidator;

/**
 * A request to make a post
 *
 * @package App\Forums\TopicMoveService
 */
class CreatePostRequest
{
    /**
     * @var Preview
     */
    private $preview;

    /**
     * @var PostCreator
     */
    private $creator;

    /**
     * @var PostValidator
     */
    private $validator;

    /**
     * @param PostValidator $validator
     * @param PostCreator $creator
     * @param Preview $preview
     */
    public function __construct(PostValidator $validator, PostCreator $creator, Preview $preview)
    {
        $this->validator = $validator;
        $this->creator = $creator;
        $this->preview = $preview;
    }

    /**
     * Move topic
     *
     * @param PostCreateListener $listener
     * @param array $input
     * @param                    $topic
     * @param                    $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create(PostCreateListener $listener, $input, $topic, $user)
    {
        // Validate
        if (!$this->validator->validate($input)) {
            return $listener->postCreateFailed($this->validator->errors());
        };

        // Show preview
        if (isset($input['preview'])) {
            return $listener->showPreview($this->preview->generatePost($input, \Auth::user()));
        }

        // Go back from preview
        if (isset($input['back'])) {
            return $listener->backFromPreview();
        }

        // Create post
        $post = $this->creator->create($input, $topic, $user);
        return $listener->postCreateSucceeded($post);
    }
}
