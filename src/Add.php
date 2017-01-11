<?php namespace Kaamaru\Forums;

use Kaamaru\Forums\Forums\ForumRepoInterface;
use Kaamaru\Forums\Posts\PostRepoInterface;
use Kaamaru\Forums\Topics\TopicRepoInterface;
use Kaamaru\Forums\Users\UserRepoInterface;

/**
 * Add post or topic to their parents and update counts
 *
 * @package App\Forums\Topic
 */
class Add
{
    /**
     * @var ForumRepoInterface
     */
    private $forumRepo;

    /**
     * @var TopicRepoInterface
     */
    private $topicRepo;

    /**
     * @var UserRepoInterface
     */
    private $userRepo;

    /**
     * @var PostRepoInterface
     */
    private $postRepo;

    /**
     * @param ForumRepoInterface $forum
     * @param TopicRepoInterface $topic
     * @param UserRepoInterface $user
     * @param PostRepoInterface $post
     */
    public function __construct(
        ForumRepoInterface $forum,
        TopicRepoInterface $topic,
        UserRepoInterface $user,
        PostRepoInterface $post
    ) {
        $this->forumRepo = $forum;
        $this->topicRepo = $topic;
        $this->userRepo = $user;
        $this->postRepo = $post;
    }

    /**
     * Add post to forums
     *
     * @param $forum
     * @param $topic
     * @param $post
     * @param $user
     */
    public function addPost($forum, $topic, $post, $user)
    {
        $this->topicRepo->addPost($topic, $post);
        $this->forumRepo->addPost($forum, $post);
        $this->userRepo->addPost($user->id);
    }

    /**
     * @param $post
     */
    public function deletePost($post)
    {
        // Change last post if needed
        $lastPost = ($post->topic->last_post = $post->id) ? $this->postRepo->getLastPost($post->topic_id) : null;

        // Delete post from topic
        $this->topicRepo->deletePost($post->topic->id, $lastPost);

        // Delete post from forums
        if ($post->topic->path) {
            $this->forumRepo->deletePost($post->topic->pathExplode());
        }

        // Delete post from users
        $this->userRepo->deletePost($post->user_id);
    }

    /**
     * Add topic to forums
     *
     * @param $forums
     * @param $topic
     * @param $user
     */
    public function addTopic($forums, $topic, $user)
    {
        if (count($forums)) {
            $this->forumRepo->addTopic($forums, $topic);
        }
        $this->userRepo->addTopic($user, $topic);
    }

    /**
     * Delete topic
     *
     * @param $topic
     */
    public function deleteTopic($topic)
    {
        if ($topic->path) {
            $this->forumRepo->deleteTopic($topic);
        }
        $this->userRepo->deleteTopic($topic);
    }

    /**
     * Add a post to a topic only
     *
     * @param $topic
     * @param $post
     */
    public function addPostToTopic($topic, $post)
    {
        $this->topicRepo->addPost($topic, $post);
    }
}
