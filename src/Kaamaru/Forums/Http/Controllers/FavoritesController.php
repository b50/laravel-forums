<?php namespace Kaamaru\Forums\Http\Controllers;

use Kaamaru\Forums\Forums\Topics\Favorite\FavoriteRepoInterface;
use Kaamaru\Forums\Forums\Topics\TopicSort;

/**
 * Show a user's favorite topics
 *
 * @package App\Controllers\Forums
 */
class FavoritesController extends BaseController
{
    /**
     * @param FavoriteRepoInterface $favorites
     * @param TopicSort $sort
     */
    public function __construct(FavoriteRepoInterface $favorites, TopicSort $sort)
    {
        $this->favorites = $favorites;
        $this->sort = $sort;
    }

    /**
     * Show a user's favorites
     */
    public function getIndex()
    {
        $favorites = $this->favorites->all($this->sort->getField(), $this->sort->getDirection());
        return View::make('kaamaru.laravel-forums.forums.favorites', compact('favorites', 'breadcrumbs'),
            ['sort' => $this->sort]);
    }

    /**
     * Add topic to favorites
     *
     * @param $topicType
     * @param $topicId
     * @param $slug
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getAdd($topicType, $topicId, $slug)
    {
        // If not already a favorite...
        if (!$this->favorites->getByPostId($topicId, \Auth::user()->id)) {
            // Save favorite
            $this->favorites->add($topicId);
        }

        // Return to the topic
        return Redirect::route('forums.topics.show', ['topicType' => $topicType, 'id' => $topicId, 'slug' => $slug]);
    }

    /**
     * Delete a topic from favorites
     *
     * @param $topicType
     * @param $topicId
     * @param $slug
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getRemove($topicType, $topicId, $slug)
    {
        // Save favorite
        $this->favorites->remove($topicId);

        // Return to the topic
        return Redirect::route('forums.topics.show', ['topicType' => $topicType, 'id' => $topicId, 'slug' => $slug]);
    }
}
