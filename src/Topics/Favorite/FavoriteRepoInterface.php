<?php namespace Kaamaru\Forums\Topics\Favorite;

/**
 * Interface FavoriteRepoInterface
 *
 * @package App\Repositories\Forums
 */
interface FavoriteRepoInterface
{
    /**
     * Save topic to favorites
     *
     * @param int $topicId
     */
    public function add($topicId);

    /**
     * Remove topic from favorites
     *
     * @param int $id
     */
    public function remove($id);

    /**
     * Get all favorites
     *
     * @param $sort
     * @param $order
     * @return \Illuminate\Pagination\Paginator
     */
    public function all($sort, $order);

    /**
     * @param int $topicId
     * @param int $userId
     * @return mixed
     */
    public function getByPostId($topicId, $userId);
}
