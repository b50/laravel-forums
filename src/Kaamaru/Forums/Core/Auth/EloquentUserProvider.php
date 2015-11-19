<?php namespace Kaamaru\Forums\Core\Auth;

class EloquentUserProvider extends \Illuminate\Auth\EloquentUserProvider
{
    /**
     * Cache user for 10 minutes
     *
     * @param  mixed $identifier
     * @return \Illuminate\Auth\UserInterface|null
     */
    public function retrieveById($identifier)
    {
        return $this->createModel()->newQuery()->remember(10)->find($identifier);
    }
}
