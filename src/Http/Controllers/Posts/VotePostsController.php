<?php namespace LaravelForums\Http\Controllers\Posts;

use LaravelForums\Forums\Posts\PostRepoInterface;
use LaravelForums\Forums\Posts\Vote\PostVoter;

/**
 * Vote post up or down
 *
 * @package App\Controllers\Forums
 */
class VotePostsController extends BasePostsController {

	/**
	 * @param PostRepoInterface $postRepo
	 * @param PostVoter         $voter
	 */
	public function __construct(PostRepoInterface $postRepo, PostVoter $voter)
	{
		$this->postRepo = $postRepo;
		$this->post = $this->postRepo->requireById(Route::current()->parameter('id'));
		$this->voter = $voter;
	}

	/**
	 * Vote a post up or down
	 *
	 * @param int    $postId
	 * @param string $direction
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function getVote($topicType, $postId, $direction)
	{
		// Vote if does not own post
		if ($this->post->user_id != \Auth::user()->id)
		{
			// Vote post up
			if ($direction == 'up')
			{
				$this->voter->increment($postId, \Auth::user()->id);
			}
			// Vote post down
			elseif ($direction == 'down')
			{
				$this->voter->decrement($postId, \Auth::user()->id);
			}
		}
		else
		{
			Flash::danger(_('You cannot vote your own post!'), 'post-'.$postId);
		}

		return $this->getShow();
	}

}
