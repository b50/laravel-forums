<?php namespace Kaamaru\Forums\Core\Paths;

/**
 * Materialized path methods
 *
 * @package App\Traits
 */
Trait PathTrait
{
    /**
     * Explode path into an array
     *
     * @return array
     */
    public function pathExplode()
    {
        return array_filter(explode('/', $this->path));
    }
}
