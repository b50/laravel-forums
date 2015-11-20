<?php namespace Kaamaru\Forums\Core;

/**
 * Sort by a field
 *
 * @package Kaamaru\Forums\Core
 */
class Sort
{
    /**
     * Fields to sort by
     *
     * In the format of [getParam => $field]
     *
     * @var array
     */
    protected $fields = [];
    /**
     * Default field to order by
     *
     * @var string
     */
    protected $defaultField = 'id';
    /**
     * Default direction to sort by
     *
     * @var string
     */
    protected $defaultDirection = 'asc';

    /**
     * Generate HTML anchor for a field
     *
     * @param string|int $id
     * @param null $title
     * @param null $defaultDirection
     * @return string
     */
    public function getSortLink($id, $title = null, $defaultDirection = null)
    {
        if (!array_key_exists($id, $this->fields)) {
            return null;
        }

        if (!$defaultDirection) {
            $defaultDirection = $this->defaultDirection;
        }

        $direction = \Input::get('direction') ?: $defaultDirection;

        if (\Input::get('order') == $id) {
            $direction = (\Input::get('direction') == 'asc') ? 'desc' : 'asc';
        }

        $params = "?order=$id&direction=$direction";
        return \Html::link(\Request::path() . $params, $title ?: ucfirst($id));
    }

    /**
     * Get field to order by
     *
     * @return mixed|string
     */
    public function getField()
    {
        if (array_key_exists(\Input::get('order'), $this->fields)) {
            return $this->fields[\Input::get('order')];
        }

        return $this->defaultField;
    }

    /**
     * Get direction to sort by
     *
     * @return mixed|string
     */
    public function getDirection()
    {
        if (in_array(\Input::get('direction'), ['asc', 'desc'])) {
            return \Input::get('direction');
        }
        return $this->defaultDirection;
    }

    /**
     * Set fields
     *
     * @param array $fields
     * @return $this
     */
    public function setFields($fields)
    {
        $this->fields = $fields;
        return $this;
    }

    /**
     * Set default field
     *
     * @param string $defaultField
     * @return $this
     */
    public function setDefaultField($defaultField)
    {
        if (in_array($defaultField, $this->fields)) {
            $this->defaultField = $defaultField;
        }

        return $this;
    }

    /**
     * Set default direction
     *
     * @param string $defaultDirection
     * @return $this
     */
    public function setDefaultDirection($defaultDirection)
    {
        if (in_array($defaultDirection, ['asc', 'desc'])) {
            $this->defaultDirection = $defaultDirection;
        }

        return $this;
    }
}
