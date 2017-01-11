<?php namespace Kaamaru\Forums\Topics\Favorite;

/**
 * Class EloquentFavorite
 *
 * @package App\Models\Forums
 */
class EloquentFavorite extends \Eloquent
{
    public $timestamps = false;
    protected $table = 'forum_favorites';

    /**
     * Is marked as read
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function read()
    {
        return $this->hasOne('Kaamaru\Forums\Topics\Read\EloquentTopicRead', 'topic_id')
            ->where('user_id', \Auth::user()->id);
    }
}
