<?php namespace LaravelForums\Core\Html;

class HtmlBuilder extends \Collective\Html\HtmlBuilder {

	public function uLink($url, $title = null, $attributes = [], $secure = null)
	{
		$url = \URL::to($url, [], $secure);

		if (is_null($title) or $title === false)
		{
			$title = $url;
		}

		return '<a href="'.$url.'"'.$this->attributes($attributes).'>'.$title.'</a>';
	}

	public function uLinkRoute($name, $title = null, $parameters = [], $attributes = [])
	{
		return $this->uLink(\URL::route($name, $parameters), $title, $attributes);
	}

	public function flash($location = null)
	{
		if ($message = $this->getMessage($location))
		{
			return '<div class="alert alert-' . e($message['status']) . '">' . e($message['content']) . '</div>';
		}

		return '';
	}

	public function flashInline($location = null)
	{
		if ($message = $this->getMessage($location))
		{
			return '<span class="' . e($message['status']) . '">' . e($message['content']) . '</span>';
		}

		return '';
	}

	protected function getMessage($location)
	{
		$status = \Session::get('message_status') ?: 'success';
		$content = \Session::get('message');

		if ($content != null and $location == \Session::get('message_location'))
		{
			\Session::remove('message');
			return compact('status', 'content');
		}
	}

	/**
	 * Generate an HTML image element if one exists
	 *
	 * @param  string  $path
	 * @param  string  $alt
	 * @param  array   $attributes
	 * @param  bool    $secure
	 * @return string
	 */
	public function imageExists($path, $alt = null, $attributes = [], $secure = null)
	{
		// Default image
		if ( ! file_exists($path))
		{
			$path = preg_replace('/\/(.*?)\/.*?(-(small|large))?.jpg$/', '/$1/default$2.jpg', $path);
		}

		// Show image
		return file_exists($path)
			? $this->image(\URL::to($path), $alt, $attributes, $secure)
			: null;
	}

}
