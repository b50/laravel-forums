<?php namespace B50\Forums\Topics\Move;

use B50\Forums\Core\Validation\Validator;

/**
 * Validate user
 *
 * @package App\Validation\Users
 */
class MoveTopicValidator extends Validator
{
    public $currentForum;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'forum' => "required|not:$this->currentForum",
        ];
    }

    /**
     * @param int $currentForum
     */
    public function setCurrentForum($currentForum)
    {
        $this->currentForum = $currentForum;
    }

    public function messages()
    {
        return [
            'not' => 'The topic is already in this forum *facepalm*'
        ];
    }
}
