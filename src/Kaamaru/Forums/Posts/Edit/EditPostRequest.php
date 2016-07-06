<?php namespace Kaamaru\Forums\Posts\Edit;

use Kaamaru\Forums\Posts\PostRepoInterface;
use Kaamaru\Forums\Preview;
use Kaamaru\Forums\Topics\Edit\TopicEditor;

/**
 * Edit a post
 *
 * @package App\Forums\TopicMoveService
 */
class EditPostRequest
{
    /**
     * @param EditPostValidator $validator
     * @param Preview $preview
     * @param TopicEditor $topic
     * @param PostEditor $post
     * @param PostRepoInterface $postRepo
     */
    public function __construct(
        EditPostValidator $validator,
        Preview $preview,
        TopicEditor $topic,
        PostEditor $post,
        PostRepoInterface $postRepo
    ) {
        $this->validator = $validator;
        $this->preview = $preview;
        $this->topicEditor = $topic;
        $this->postEditor = $post;
        $this->postRepo = $postRepo;
    }

    /**
     * Move topic
     *
     * @param PostEditListener $listener
     * @param array $input
     * @param $post
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit(PostEditListener $listener, $input, $post)
    {
        // Validate
        if (!$this->validator->validate($input)) {
            return $listener->postEditFailed($this->validator->errors());
        }

        // Show preview
        if (isset($input['preview'])) {
            // Create preview
            $preview = $this->preview->generatePost($input, $post->author);

            if ($this->postRepo->isFirst($post)) {
                return $listener->showPreview($preview, $input['title']);
            }

            return $listener->showPreview($preview);
        }

        // Go back from preview
        if (isset($input['back'])) {
            return $listener->getEdit();
        }

        // Edit post
        $this->postEditor->edit($post->id, $input);

        // Edit topic
        if ($this->postRepo->isFirst($post)) {
            $this->topicEditor->edit($post->topic_id, $input);
        }

        return $listener->postEditSucceeded();
    }
}
