<?php namespace Kaamaru\Forums\Forums\Topics;

use Kaamaru\Forums\Core\Sort;

class TopicSort extends Sort
{
    protected $fields = [
        'title' => 'forum_topics.title',
        'views' => 'forum_topics.views',
        'replies' => 'forum_topics.posts_count',
        'last_post' => 'forum_topics.updated_at',
        'votes' => 'first_post.votes',
    ];
    protected $defaultField = 'last_post';
    protected $defaultDirection = 'desc';
}
