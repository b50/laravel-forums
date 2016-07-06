<?php namespace Kaamaru\Forums\Topics\Read;

use Kaamaru\Forums\Core\Repositories\EloquentRepo;

class EloquentTopicReadRepo extends EloquentRepo implements TopicReadRepoInterface
{
    public function __construct(EloquentTopicRead $read)
    {
        $this->model = $read;
    }

    /**
     * {@inheritDocs}
     */
    public function markAsRead($topicId, $userId)
    {
        if (!$this->model->where('topic_id', $topicId)->where('user_id', $userId)->first()) {
            $this->model->insert([
                'topic_id' => $topicId,
                'user_id' => $userId,
            ]);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function clearRead($topic, $userId = null)
    {
        if ($userId) {
            $this->model->where('topic_id', $topic)->where('user_id', $userId)->delete();
        } else {
            $this->model->where('topic_id', $topic)->delete();
        }
    }
}
