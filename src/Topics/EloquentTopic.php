<?php namespace B50\Forums\Topics;

use Illuminate\Database\Eloquent\SoftDeletes;
use B50\Forums\Forums\EloquentForum;
use B50\Forums\Posts\EloquentPost;
use B50\Forums\Topics\Favorite\EloquentFavorite;
use B50\Forums\Topics\Read\EloquentTopicRead;
use B50\Forums\Users\EloquentUser;
use McCool\LaravelAutoPresenter\HasPresenter;

/**
 * Eloquent topic
 *
 * @package App\Models\Forums
 */
class EloquentTopic extends \Eloquent implements HasPresenter
{
    use SoftDeletes;

    /**
     * We need to update manually as topic may be updated
     * without needing to show a new post
     *
     * @var bool
     */
    public $timestamps = true;

    public $fillable = [
        'title', 'slug', 'forum_id', 'updated_at', 'created_at', 'user_id'
    ];

    /**
     * @var  int  the number of pages
     */
    public $pages = 0;
    /**
     * Posts pagination cache
     */
    protected $posts;
    /**
     * @var string
     */
    protected $table = 'lforums_topics';

    /**
     * Relate topic to it's posts
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts()
    {
        return $this
            ->hasMany(EloquentPost::class, 'topic_id')
            ->with('author');
    }

    /**
     * Is marked as read
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function read()
    {
        return $this
            ->hasOne(EloquentTopicRead::class, 'topic_id')
            ->where('user_id', \Auth::user()->id);
    }

    /**
     * Relate to a topic's author
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo(EloquentUser::class);
    }

    /**
     * The last post user of the topic
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function last_user()
    {
        return $this->belongsTo(EloquentUser::class, 'last_post_user_id', 'id');
    }

    /**
     * The last post of the topic
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function last_post()
    {
        return $this->belongsTo(EloquentPost::class, 'last_post_id', 'id');
    }

    public function favorite()
    {
        return $this
            ->hasOne(EloquentFavorite::class, 'topic_id')
            ->where('user_id', \Auth::user()->id);
    }

    public function firstPost()
    {
        return $this
            ->hasOne(EloquentPost::class, 'topic_id')
            ->orderBy('id')->with('author');
    }

    public function developerResponse()
    {
        return $this->hasOne(EloquentPost::class, 'topic_id')
            ->where('developer_response', true)->with('author');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function parent()
    {
        return $this->hasOne(EloquentForum::class, 'id', 'forum_id');
    }

    /**
     * Paginated posts accessor.
     *
     * @return \Illuminate\Pagination\Paginator
     */
    public function getPostsAttribute()
    {
        if ($this->posts) {
            return $this->posts;
        }

        return $this->posts = $this
            ->posts()
            ->paginate(config('forums.posts_per_page'));
    }

    /**
     * Paginated posts accessor.
     *
     * @return \Illuminate\Pagination\Paginator
     */
    public function getPostsByVotesAttribute()
    {
        if ($this->posts) {
            return $this->posts;
        }

        return $this->posts = $this->posts()
            ->orderBy('votes', 'desc')
            ->where('developer_response', false)
            ->paginate(config('forums.posts_per_page'));
    }

    /**
     * Get topic ancestors
     *
     * @return mixed
     */
    public function getParentsAttribute()
    {
        $forum = EloquentForum::find($this->forum_id);
        return $forum->parents;
    }

    /**
     * Get the presenter class.
     *
     * @return string The class path to the presenter.
     */
    public function getPresenterClass()
    {
        return TopicPresenter::class;
    }
}
