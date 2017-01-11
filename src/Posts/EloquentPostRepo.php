<?php namespace B50\Forums\Posts;

use B50\Forums\Core\Repositories\EloquentRepo;

/**
 * Class EloquentPostRepo
 *
 * @package App\Repositories\Forums
 */
class EloquentPostRepo extends EloquentRepo implements PostRepoInterface
{
    protected $model;

    /**
     * @param EloquentPost $post
     */
    public function __construct(EloquentPost $post)
    {
        $this->model = $post;
    }

    /**
     * {@inheritDoc}
     */
    public function getRecent()
    {
        return $this->model
            ->select('id', 'created_at', 'author_id', 'topic_id')
            ->with([
                'topic' => function ($query) {
                    $query
                        ->where('expires_at', null)
                        ->where('deleted_at', null);
                }, 'author'
            ])
            ->orderBy('created_at', 'desc')
            ->take(\Config::get('forums/forum.recent'))
            ->get();
    }

    /**
     * {@inheritDoc}
     */
    public function create($input)
    {
        return $this->model->create($input);
    }

    /**
     * {@inheritDoc}
     */
    public function edit($postId, $data)
    {
        return $this->model->where('id', $postId)->update($data);
    }

    /**
     * {@inheritDoc}
     */
    public function getPostPage($post)
    {
        $position = $this->model
                ->where('id', '<', $post->id)
                ->where('topic_id', $post->topic_id)
                ->count() + 1;
        $postsPerPage = \Config::get('forums.posts_per_page');
        return ceil($position / $postsPerPage);
    }

    /**
     * {@inheritDoc}
     */
    public function delete($id)
    {
        $this->model->where('id', $id)->delete();
    }

    /**
     * {@inheritDoc}
     */
    public function getEmptyPost()
    {
        return $this->model;
    }

    /**
     * {@inheritDoc}
     */
    public function getFirstPostId($topicId)
    {
        return $this->model
            ->where('topic_id', $topicId)
            ->orderBy('id')
            ->first(['id'])->id;
    }

    /**
     * {@inheritDoc}
     */
    public function getLastPost($topicId)
    {
        return $this->model
            ->where('topic_id', $topicId)
            ->orderBy('id', 'desc')
            ->first();
    }

    /**
     * {@inheritDoc}
     */
    public function incrementVote($postId)
    {
        $this->model->where('id', $postId)->increment('votes');
    }

    /**
     * {@inheritDoc}
     */
    public function decrementVote($postId)
    {
        $this->model->where('id', $postId)->decrement('votes');
    }

    /**
     * Find out if a post is the first post in the topic
     *
     * @param $post
     * @return bool
     */
    public function isFirst($post)
    {
        return $post->id == $this->model->orderBy('id')
            ->where('topic_id', $post->topic_id)
            ->first()->id;
    }
}
