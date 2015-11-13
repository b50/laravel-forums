<?php namespace LaravelForums\Core\Markdown;

use LaravelForums\Users\UserRepoInterface;

/**
 * Class Markdown
 *
 * @package App\Classes
 */
class Markdown extends \Parsedown {

	public function __construct(UserRepoInterface $user)
	{
	    $this->userRepo = $user;
	}
	
	public function text($text)
	{
		$text = parent::text($text);

		$text = $this->convertAtUsernameToUser($text);

		return $text;

	}

	/**
	 * Convert @username to a link to the user
	 *
	 * @param $text
	 * @return string
	 */
	protected function convertAtUsernameToUser($text)
	{
		preg_match_all("/\@([a-z0-9_-]+)/i", $text, $matches);

		if ($matches[1])
		{
			$users = $this->userRepo->getBySlug($matches[1]);

			foreach ($users as $user)
			{
				$link = \HTML::linkRoute('users.show', $user->username, ['slug' => $user->slug]);
				$text = preg_replace("/\@$user->slug/i", $link, $text);
			}
		}

		return $text;
	}

}
