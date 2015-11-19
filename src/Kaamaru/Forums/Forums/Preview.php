<?php namespace Kaamaru\Forums\Forums;

use Kaamaru\Forums\Forums\Posts\PostRepoInterface;
use Kaamaru\Forums\Forums\Topics\TopicRepoInterface;

/**
 * Topic\Post Preview generation
 *
 * @package Kaamaru\Forums\Forums\Services
 */
class Preview
{
    /**
     * @param TopicRepoInterface $topic
     * @param PostRepoInterface $post
     */
    public function __construct(TopicRepoInterface $topic, PostRepoInterface $post)
    {
        $this->topicRepo = $topic;
        $this->postRepo = $post;
    }

    /**
     * Generate a preview
     *
     * @param $input
     * @return \Illuminate\View\View
     */
    public function generateTopic($input)
    {
        // Generate preview topic
        $topic = $this->topicRepo->getEmptyTopic();
        $topic->title = $input['title'];

        return $topic;
    }

    /**
     * Generate a preview
     *
     * @param array $input
     * @param       $user
     * @return \Illuminate\View\View
     */
    public function generatePost($input, $user)
    {
        // Generate preview post
        $post = $this->postRepo->getEmptyPost();
        $post->author = $user;
        $post->markdown = $input['content'];
        $post->html = \Purifier::clean(\Markdown::text($input['content']));

        return $post;
    }
}
