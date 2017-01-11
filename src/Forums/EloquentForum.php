<?php namespace Kaamaru\Forums\Forums;

use Carbon\Carbon;
use Kaamaru\Forums\Core\Paths\PathInterface;
use Kaamaru\Forums\Core\Paths\PathTrait;
use Kaamaru\Forums\Read\EloquentForumRead;
use Kaamaru\Forums\Topics\EloquentTopic;
use McCool\LaravelAutoPresenter\HasPresenter;
use McCool\LaravelAutoPresenter\PresenterInterface;

/**
 * Class EloquentForum
 *
 * @package Kaamaru\Forums\Forums
 */
class EloquentForum extends \Eloquent implements PathInterface, HasPresenter
{
    use PathTrait;
    /**
     * @var bool
     */
    public $timestamps = false;
    /**
     * @var string
     */
    protected $table = 'lforums';
    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * Is marked as read
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function read()
    {
        return $this->hasOne(EloquentForumRead::class, 'forum_id')
            ->where('user_id', \Auth::user()->id);
    }

    /**
     * Topic relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function topics()
    {
        return $this->hasMany(EloquentTopic::class, 'forum_id');
    }

    /**
     * Get topic ancestors
     *
     * @return mixed
     */
    public function getParentsAttribute()
    {
        return $this
            ->WhereIn('id', $this->pathExplode())
            ->orderBy(\DB::raw('LENGTH(path)'))
            ->get();
    }

    /**
     * @return string
     */
    public function getPresenterClass()
    {
        return 'Kaamaru\Forums\Forums\ForumPresenter';
    }

    /**
     * Return a forum's parent
     */
    public function parent()
    {
        $parents = $this->pathExplode();

        if (count($parents) < 2) {
            return null;
        }

        return $parents[count($parents) - 2];
    }

}
