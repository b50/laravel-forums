<?php namespace Kaamaru\Forums\Core\Revisionable;

class RevisionableObserver
{
    public static function saved($model)
    {
        $model->postSave();
    }

    public static function saving($model)
    {
        $model->preSave();
    }

    public static function deleted($model)
    {
        $model->preSave();
        $model->postDelete();
    }
}
