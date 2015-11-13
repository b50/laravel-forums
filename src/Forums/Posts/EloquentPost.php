<?php namespace LaravelForums\Forums\Posts;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\SoftDeletingTrait;
use McCool\LaravelAutoPresenter\HasPresenter;

/**
 * Class EloquentPost
 *
 * @package App\Models\Forums
 */
class EloquentPost extends \Eloquent implements HasPresenter {

	use SoftDeletes;

	public $fillable = ['markdown', 'html', 'topic_id', 'user_id', 'developer_response'];

	public static $rules = [
		'markdown' => 'required|between:3,20000',
		'topic_id' => 'required|integer',
		'user_id' => 'required|integer',
	];

	protected $table = 'forum_posts';

	/**
	 * Topic relation
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function topic()
	{
		return $this->belongsTo('LaravelForums\Forums\Topics\EloquentTopic');
	}

	/**
	 * Author relation
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function author()
	{
		return $this->belongsTo('LaravelForums\Users\EloquentUser', 'user_id', 'id')->with(['groups' => function($query)
		{
			$query->whereIn('group', ['Admin', 'Moderator']);
		}]);
	}

	/**
	 * Post presenter
	 *
	 * @return string
	 */
	public function getPresenterClass()
	{
		return 'LaravelForums\Forums\Posts\PostPresenter';
	}

}