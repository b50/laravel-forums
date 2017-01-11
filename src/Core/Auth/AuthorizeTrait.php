<?php namespace B50\Forums\Core\Auth;

/**
 * Class EloquentAncestorsTrait
 *
 * @package App\Traits
 */
trait AuthorizeTrait
{
    /**
     * Return if no access and not the owner of the entity
     *
     * @param $permission
     * @param $entity
     * @return bool
     */
    protected function noAccessNotOwner($permission, $entity)
    {
        if (\Bouncer::hasPermissionOrIsOwner($permission, $entity->user_id)) {
            return false;
        }

        return $this->noAccessReturn($entity);
    }

    /**
     * Return if no access
     *
     * @param $permission
     * @param $entity
     * @return bool
     */
    protected function noAccess($permission, $entity)
    {
        if (\Bouncer::hasPermission($permission)) {
            return false;
        }

        return $this->noAccessReturn($entity);
    }

    /**
     * What to return if no access
     *
     * @param $entity
     * @return \Illuminate\Support\Facades\Redirect
     */
    abstract public function noAccessReturn($entity);
}
