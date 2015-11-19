<?php namespace Kaamaru\Forums\Forums\Posts\Create;

use Kaamaru\Forums\Forums\Add;
use Kaamaru\Forums\Forums\Forums\Read\ForumReadRepoInterface;
use Kaamaru\Forums\Forums\Posts\PostRepoInterface;
use Kaamaru\Forums\Forums\Topics\Read\TopicReadRepoInterface;

/**
 * Class PostCreator
 *
 * @package App\Forums\Services
 */
class PostCreator
{
    /**
     * @param PostRepoInterface $post
     * @param Add $add
     * @param ForumReadRepoInterface $forumRead
     * @param TopicReadRepoInterface $topicRead
     */
    public function __construct(
        PostRepoInterface $post,
        Add $add,
        ForumReadRepoInterface $forumRead,
        TopicReadRepoInterface $topicRead
    ) {
        $this->postRepo = $post;
        $this->add = $add;
        $this->forumRead = $forumRead;
        $this->topicRead = $topicRead;
    }

    /**
     * Create post
     *
     * @param array $input
     * @param                $topic
     * @param                $user
     * @param bool $add
     * @return \Illuminate\Http\RedirectResponse|object
     */
    public function create($input, $topic, $user, $add = true)
    {
        // Create post
        $data = [
            'markdown' => $input['content'],
            'html' => \Purifier::clean(\Markdown::text($input['content'])),
            'topic_id' => $topic->id,
            'user_id' => $user->id
        ];

        if (\Bouncer::hasPermission('devresponse') and \Input::get('devresponse') == 1) {
            $data['developer_response'] = true;
        }

        $post = $this->postRepo->create($data);

        return $post;
    }

    public function clearRead($topic)
    {
        // Clear forums read markers
        $this->forumRead->clearRead($topic->pathExplode());

        // Clear topic read markers
        $this->topicRead->clearRead($topic->id);
    }

    public function addPost($topic, $post, $user)
    {
        $this->add->addPost($topic->pathExplode(), $topic, $post, $user);
    }
}
