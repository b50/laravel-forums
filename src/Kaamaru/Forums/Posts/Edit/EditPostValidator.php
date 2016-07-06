<?php namespace Kaamaru\Forums\Posts\Edit;

use Kaamaru\Forums\Posts\PostValidator;

/**
 * Edit post validation
 *
 * @package App\Validation\Users
 */
class EditPostValidator extends PostValidator
{
    /**
     * @return array
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            'title' => 'min:3',
        ]);
    }
}
