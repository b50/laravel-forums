<?php namespace B50\Forums\Topics\Favorite;

/**
 * Class EloquentFavorite
 *
 * @package App\Models\Forums
 */
class EloquentFavorite extends \Eloquent
{
    public $timestamps = false;
    protected $table = 'lforums_favorites';

    /**
     * Is marked as read
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function read()
    {
        return $this->hasOne('B50\Forums\Topics\Read\EloquentTopicRead', 'topic_id')
            ->where('user_id', \Auth::user()->id);
    }
}
