<?php namespace LaravelForums\Forums\Posts;

/**
 * Generate quotes
 *
 * @package App\Composers\Forums
 */
class QuotesComposer {

	/**
	 * @param $view
	 */
	public function compose($view)
	{
		// Stop if no quotes
		if ( ! $view->quotes)
		{
			return;
		}

		// Parse quotes
		$quotes = [];
		foreach($view->quotes as $quote)
		{
			$quotes[] = \View::make('forums._quote', compact('quote'));
		}

		$view->quotes = implode("\n", $quotes);
	}

}
