<?php namespace LaravelForums\Core\Repositories;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

interface RepoInterface {

	/**
	 * Get by id
	 *
	 * @param int $id
	 * @param array $columns
	 * @return \Illuminate\Support\Collection|static
	 */
	public function getById($id, $columns = ['*']);

	/**
	 * require by id or throw exception
	 *
	 * @param $id
	 * @param array $columns
	 * @return mixed
	 * @throws NotFoundHttpException
	 */
	public function requireById($id, $columns = ['*']);

	/**
	 * Increment column
	 *
	 * @param $id
	 * @param $column
	 * @param $value
	 * @return mixed
	 */
	public function increment($id, $column, $value = 1);

	/**
	 * Decrement column
	 *
	 * @param $id
	 * @param $column
	 * @param $value
	 * @return mixed
	 */
	public function decrement($id, $column, $value = 1);

}
