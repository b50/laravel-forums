<?php namespace B50\Forums;

use B50\Forums\Posts\PostRepoInterface;
use B50\Forums\Topics\TopicRepoInterface;

/**
 * Topic\Post Preview generation
 *
 * @package B50\Forums\Services
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
