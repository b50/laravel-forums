<?php namespace LaravelForums\Core\Repositories;

use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

abstract class EloquentRepo implements RepoInterface {

	/**
	 * @var Model
	 */
	protected $model;

	/**
	 * {@inheritDocs}
	 */
	public function getById($id, $columns = ['*'])
	{
		return $this->model->find($id, $columns);
	}

	/**
	 * {@inheritDocs}
	 */
	public function requireById($id, $columns = ['*'])
	{
		return $this->makeRequired($this->getById($id), $columns);
	}

	/**
	 * {@inheritDocs}
	 */
	public function increment($id, $column, $value = 1)
	{
		$this->model->where('id', $id)->increment($column, $value);
	}

	/**
	 * {@inheritDocs}
	 */
	public function decrement($id, $column, $value = 1)
	{
		$this->model->where('id', $id)->decrement($column, $value);
	}

	/**
	 * Make something required
	 *
	 * @param $model
	 * @throws NotFoundHttpException;
	 * @return Model
	 */
	protected function makeRequired($model)
	{
		if ($model)
		{
			return $model;
		}

		throw new NotFoundHttpException;
	}

}
