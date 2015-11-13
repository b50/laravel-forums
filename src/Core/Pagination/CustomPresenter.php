<?php namespace LaravelForums\Core\Pagination;

use Illuminate\Pagination\Presenter;

/**
 * Our custom pagination
 *
 * @package LaravelForums\Core\Presenters
 */
class CustomPresenter extends Presenter {

	/**
	 * {@inheritDoc}
	 */
	public function getPageLinkWrapper($url, $page, $rel = null)
	{
		$rel = is_null($rel) ? '' : ' rel="'.$rel.'" class="'.$rel.'"';

		$pageClass = (is_int($page))
			? ' class="page"'
			: '';

		return '<li><a href="'.$url.'"'.$rel.$pageClass.'>'.$page.'</a></li>';
	}

	/**
	 * {@inheritDoc}
	 */
	public function getDisabledTextWrapper($text)
	{
		return '<li class="disabled"><span>'.$text.'</span></li>';
	}

	/**
	 * {@inheritDoc}
	 */
	public function getActivePageWrapper($text)
	{
		return '<li class="active"><span class="page">'.$text.'</span></li>';
	}

	/**
	 * {@inheritDoc}
	 */
	public function getPrevious($text = 'Previous')
	{
		if ($this->currentPage > 1)
		{
			return parent::getPrevious($text);
		}

		return null;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getNext($text = 'Next')
	{
		if ($this->currentPage < $this->lastPage)
		{
			return parent::getNext($text);
		}

		return null;
	}

}
