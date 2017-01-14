<?php namespace B50\Forums\Topics;

use B50\Forums\Core\Sort;

class TopicSort extends Sort
{
    protected $fields = [
        'title' => 'lforums_topics.title',
        'views' => 'lforums_topics.views',
        'replies' => 'lforums_topics.posts_count',
        'last_post' => 'lforums_topics.updated_at',
        'votes' => 'first_post.votes',
    ];
    protected $defaultField = 'last_post_id';
    protected $defaultDirection = 'desc';
}
