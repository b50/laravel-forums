<?php namespace Kaamaru\Forums\Forums\Forums;

use Kaamaru\Forums\Core\Paths\PathInterface;
use Kaamaru\Forums\Core\Paths\PathTrait;
use Carbon\Carbon;
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
     * Subforums cache
     */
    protected $subforums;

    /**
     * Is marked as read
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function read()
    {
        return $this->hasOne('Kaamaru\Forums\Forums\Forums\Read\EloquentForumRead', 'forum_id')
            ->where('user_id', \Auth::user()->id);
    }

    /**
     * Get topic ancestors
     *
     * @return mixed
     */
    public function getParentsAttribute()
    {
        return $this
            ->WhereIn('id', $this->pathExplode())->orderBy(\DB::raw('LENGTH(path)'))->get();
    }

    /**
     * @return string
     */
    public function getPresenterClass()
    {
        return 'Kaamaru\Forums\Forums\Forums\ForumPresenter';
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
